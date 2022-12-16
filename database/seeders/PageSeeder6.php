<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder6 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Page::query()->whereIn('key',['cart','shipping','payment','favorites','sipping'])->delete();
        // Pages array
        $pages = [
            [
                'key' => 'special'
            ],
            [
                'key' => 'you_may_like'
            ],
        ];

        // Insert Pages
        Page::insert($pages);
    }
}
