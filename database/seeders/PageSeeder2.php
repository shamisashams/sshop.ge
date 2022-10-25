<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder2 extends Seeder
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
                'key' => 'term_condition'
            ],

        ];

        // Insert Pages
        Page::insert($pages);
    }
}
