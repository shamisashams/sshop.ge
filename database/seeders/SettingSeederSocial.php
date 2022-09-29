<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeederSocial extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Settings array
        $Settings = [

            [
                'key' => 'tiktok'
            ],
            [
                'key' => 'linkedin'
            ],

        ];

        // Insert Settings
        Setting::insert($Settings);
    }
}
