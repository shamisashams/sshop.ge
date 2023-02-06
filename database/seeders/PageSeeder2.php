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
            [
                'key' => 'guarantee'
            ],
            [
                'key' => 'shipping_payment'
            ],
            [
                'key' => 'privacy_policy'
            ],
            [
                'key' => 'news'
            ],
            [
                'key' => 'popular'
            ],
            [
                'key' => 'special'
            ],
            [
                'key' => 'you_may_like'
            ],
            [
                'key' => 'cart'
            ],
            [
                'key' => 'shipping'
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
