<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder5 extends Seeder
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
                'key' => 'cart'
            ],
            [
                'key' => 'sipping'
            ],
            [
                'key' => 'payment'
            ],
            [
                'key' => 'favorites'
            ]
        ];

        // Insert Pages
        Page::insert($pages);
    }
}
