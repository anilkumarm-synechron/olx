<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\User;
use App\Models\AdPhoto;
use Illuminate\Support\Facades\Storage;

class AdsTableSeeder extends Seeder
{
    public function run(): void
    {
        if(!extension_loaded('gd')) {
            echo "GD extension not loaded. Skipping image generation.\n"; // fallback silently
        }

        $users = User::all();
        if ($users->isEmpty()) {
            return; // rely on UsersTableSeeder first
        }

        $samples = [
            ['Gaming Laptop', 'High performance laptop suitable for gaming and work', 1200.00],
            ['iPhone 14 Pro', 'Lightly used, excellent condition with box', 950.00],
            ['Mountain Bike', '26-inch alloy frame, recently serviced', 300.00],
            ['Office Chair', 'Ergonomic mesh chair with lumbar support', 110.00],
            ['Smart TV 55"', '4K UHD HDR, barely used', 500.00],
            ['Vintage Camera', 'Film camera working condition collector piece', 220.00],
        ];

        $placeholderDir = 'ads/placeholders';
        if(!Storage::disk('public')->exists($placeholderDir)) {
            Storage::disk('public')->makeDirectory($placeholderDir);
        }

        foreach ($samples as $item) {
            $ad = Ad::create([
                'user_id' => $users->random()->id,
                'title' => $item[0],
                'description' => $item[1],
                'price' => $item[2],
                'status' => 'active'
            ]);

            // Build filename
            $safeTitle = preg_replace('/[^A-Za-z0-9]+/','_', strtolower($ad->title));
            $filename = 'ad_'.$ad->id.'_'.$safeTitle.'.png';
            $path = $placeholderDir . '/' . $filename;

            if(extension_loaded('gd')) {
                $this->generatePngPlaceholder($path, $ad->title);
            } else {
                // Fallback simple text file if GD missing
                Storage::disk('public')->put(str_replace('.png','.txt',$path), 'Placeholder for Ad #'.$ad->id.' - '.$ad->title);
                $path = str_replace('.png','.txt',$path);
            }

            AdPhoto::create([
                'ad_id' => $ad->id,
                'path' => $path,
                'is_primary' => true,
            ]);
        }
    }

    private function generatePngPlaceholder(string $relativePath, string $title): void
    {
        $width = 600; $height = 450;
        $im = imagecreatetruecolor($width, $height);

        // Random pastel background
        $bg = imagecolorallocate($im, rand(120,200), rand(120,200), rand(120,200));
        imagefilledrectangle($im, 0, 0, $width, $height, $bg);

        $textColor = imagecolorallocate($im, 30, 30, 30);
        $wrapTitle = wordwrap(substr($title,0,40), 18, "\n");

        // Basic font rendering (GD built-in font)
        $lines = explode("\n", $wrapTitle);
        $font = 5; // built-in font size
        $lineHeight = imagefontheight($font) + 4;
        $totalTextHeight = count($lines) * $lineHeight;
        $y = ($height - $totalTextHeight)/2;
        foreach($lines as $line) {
            $textWidth = imagefontwidth($font) * strlen($line);
            $x = ($width - $textWidth)/2;
            imagestring($im, $font, (int)$x, (int)$y, $line, $textColor);
            $y += $lineHeight;
        }

        // Watermark footer
        $footer = 'OLX DEMO';
        $fw = imagefontwidth(3) * strlen($footer);
        $fh = imagefontheight(3);
        imagestring($im, 3, $width - $fw - 10, $height - $fh - 8, $footer, $textColor);

        ob_start();
        imagepng($im);
        $pngData = ob_get_clean();
        imagedestroy($im);

        Storage::disk('public')->put($relativePath, $pngData);
    }
}
