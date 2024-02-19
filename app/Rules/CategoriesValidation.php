<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Category;

class CategoriesValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $categories = json_decode(request()->input('categories'));
        $all_ids_are_valid = true;

        foreach($categories as $category):

            (!Category::getById($category)) ? $all_ids_are_valid = false : '';


        endforeach;

        return $all_ids_are_valid;
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The category does not exist';
    }
}
