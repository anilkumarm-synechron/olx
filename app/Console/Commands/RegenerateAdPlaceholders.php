<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ad;
use App\Models\AdPhoto;
use Illuminate\Support\Facades\Storage;

class RegenerateAdPlaceholders extends Command
{
    protected $signature = 'ads:placeholders {--force : Overwrite existing primary placeholder images even if present} {--only-missing : Only process ads missing a primary photo}';
    protected $description = 'Generate or regenerate placeholder images for ads (PNG via GD, fallback text file).';

    public function handle(): int
    {
        $force = $this->option('force');
        $onlyMissing = $this->option('only-missing');

        if(!extension_loaded('gd')) {
            $this->warn('GD extension not loaded. Will create .txt fallback placeholders.');
        }

        $query = Ad::query()->with(['photos' => function($q){ $q->orderByDesc('is_primary'); }]);
        $ads = $query->get();
        $processed = 0; $skipped = 0; $created = 0; $updated = 0;

        $placeholderDir = 'ads/placeholders';
        if(!Storage::disk('public')->exists($placeholderDir)) {
            Storage::disk('public')->makeDirectory($placeholderDir);
        }

        foreach($ads as $ad) {
            $primary = $ad->photos->firstWhere('is_primary', true) ?? $ad->photos->first();

            if($onlyMissing && $primary) {
                $skipped++; continue; // has something already
            }

            if($primary && !$force && !$onlyMissing) {
                $skipped++; continue; // respect existing unless force
            }

            $safeTitle = preg_replace('/[^A-Za-z0-9]+/','_', strtolower($ad->title));
            $filename = 'ad_'.$ad->id.'_'.$safeTitle.'.png';
            $relativePath = $placeholderDir . '/' . $filename;

            if(extension_loaded('gd')) {
                $this->generatePngPlaceholder($relativePath, $ad->title);
            } else {
                // fallback txt
                $txtPath = str_replace('.png', '.txt', $relativePath);
                Storage::disk('public')->put($txtPath, 'Placeholder for Ad #'.$ad->id.' - '.$ad->title);
                $relativePath = $txtPath;
            }

            if($primary) {
                // update
                $primary->path = $relativePath;
                $primary->is_primary = true;
                $primary->save();
                $updated++;
            } else {
                AdPhoto::create([
                    'ad_id' => $ad->id,
                    'path' => $relativePath,
                    'is_primary' => true,
                ]);
                $created++;
            }

            $processed++;
            $this->line("Ad #{$ad->id}: placeholder set -> {$relativePath}");
        }

        $this->info("Processed: $processed | Created: $created | Updated: $updated | Skipped: $skipped");
        return Command::SUCCESS;
    }

    private function generatePngPlaceholder(string $relativePath, string $title): void
    {
        $width = 600; $height = 450;
        $im = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($im, rand(120,200), rand(120,200), rand(120,200));
        imagefilledrectangle($im, 0, 0, $width, $height, $bg);
        $textColor = imagecolorallocate($im, 30, 30, 30);
        $wrapTitle = wordwrap(substr($title,0,40), 18, "\n");
        $lines = explode("\n", $wrapTitle);
        $font = 5; $lineHeight = imagefontheight($font) + 4; $totalTextHeight = count($lines) * $lineHeight; $y = ($height - $totalTextHeight)/2;
        foreach($lines as $line) {
            $textWidth = imagefontwidth($font) * strlen($line);
            $x = ($width - $textWidth)/2;
            imagestring($im, $font, (int)$x, (int)$y, $line, $textColor);
            $y += $lineHeight;
        }
        $footer = 'OLX DEMO'; $fw = imagefontwidth(3) * strlen($footer); $fh = imagefontheight(3);
        imagestring($im, 3, $width - $fw - 10, $height - $fh - 8, $footer, $textColor);
        ob_start(); imagepng($im); $pngData = ob_get_clean(); imagedestroy($im);
        Storage::disk('public')->put($relativePath, $pngData);
    }
}
