<?php

namespace App\Rules;

use App\Models\Attribute;
use App\Models\ProductSet;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder as Builder_;
use Illuminate\Http\Request;

class ColorMatch implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $request;

    public function __construct($request)
    {
        //
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $attributes = Attribute::where('code','color')->first();

        //dd($attributes,$this->request->all());






        $color_id = $this->request->post('attribute')[$attributes->id];



        //dd($color_id);
        //
        $collection_color = ProductSet::where('id',$this->request->collection_id)->whereHas('colors',function (Builder_ $query) use ($color_id){
            $query->where('color_id',$color_id);
        })->count();
        return $collection_color;
        //dd($collection_color);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'collection color not match product color!';
    }
}
