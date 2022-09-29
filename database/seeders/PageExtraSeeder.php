<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Page::truncate();
        // Pages array
        $pages = [
            [
                'key' => 'furniture_set'
            ],

        ];

        // Insert Pages
        Page::insert($pages);
    }
}
