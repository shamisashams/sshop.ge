<?php

namespace App\Rules;

use App\Models\Attribute;
use App\Models\ProductSet;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder as Builder_;
use Illuminate\Http\Request;

class ColorMatchCollection implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $collection;

    public function __construct($collection,$request)
    {
        //
        $this->collection = $collection;
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
        if($this->collection->products()->count() > 0){
            $color = $this->collection->colors()->first();

            if($color->id != $value){
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'collection color not match products color!';
    }
}
