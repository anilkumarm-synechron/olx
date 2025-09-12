<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Ad;
use App\Models\AdPhoto;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Clean storage placeholders directory (optional safety)
        if(Storage::disk('public')->exists('ads')){
            // Not deleting to avoid unintended removal of user uploads in real app
        }

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '9990000001'
        ]);

        $users = [];
        for($i=1;$i<=5;$i++){
            $users[] = User::create([
                'name' => 'User '.$i,
                'email' => 'user'.$i.'@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => str_pad((string)(9990000001+$i),'10','0',STR_PAD_LEFT)
            ]);
        }

        $all = array_merge([$admin], $users);

        $titles = [
            'Sample Ad A','Sample Ad B','Sample Ad C','Sample Ad D','Sample Ad E'
        ];

        foreach($all as $u){
            foreach($titles as $idx => $title){
                $ad = Ad::create([
                    'user_id' => $u->id,
                    'title' => $title.' #'.$u->id,
                    'description' => 'Description for '.$title.' by user '.$u->id,
                    'price' => ($idx+1)*10,
                    'status' => 'active'
                ]);
                // minimal placeholder
                $rel = 'ads/placeholders/ad_'.$ad->id.'.txt';
                Storage::disk('public')->put($rel, 'Placeholder for Ad '.$ad->id);
                AdPhoto::create([
                    'ad_id' => $ad->id,
                    'path' => $rel,
                    'is_primary' => true
                ]);
            }
        }
    }
}
