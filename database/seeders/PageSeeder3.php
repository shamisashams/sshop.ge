<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder3 extends Seeder
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
                'key' => 'guarantee'
            ],
            [
                'key' => 'shipping_payment'
            ],
        ];

        // Insert Pages
        Page::insert($pages);
    }
}
