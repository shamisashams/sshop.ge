<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {

        //
        $attributes = [
            [
                'code' => 'size',
                'type' => 'select'
            ],
            [
                'code' => 'color',
                'type' => 'select'
            ],
            [
                'code' => 'brand',
                'type' => 'select'
            ]
        ];

        foreach ($attributes as $item){
            $attribute = Attribute::query()->create($item);
            if($item['code'] == 'corner'){
                $options = [
                  ['code' => 'left'],
                  ['code' => 'right']
                ];
                foreach ($options as $option){
                    $attribute->options()->create($option);
                }
            }

        }


    }
}
