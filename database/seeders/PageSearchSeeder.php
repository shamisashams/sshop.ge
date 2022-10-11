<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSearchSeeder extends Seeder
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
            /*[
                'key' => 'search'
            ],*/
            [
                'key' => 'news'
            ]

        ];

        // Insert Pages
        Page::insert($pages);
    }
}
