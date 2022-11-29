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
        Page::query()->whereIn('key',['cart','shipping','payment','favorites','sipping'])->delete();
        // Pages array
        $pages = [
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
