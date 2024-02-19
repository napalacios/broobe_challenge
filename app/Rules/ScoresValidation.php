<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ScoresValidation implements Rule
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
        $scores = json_decode(request()->input('scores'));
        $all_scores_are_valid = true;

        foreach($scores as $score):
            
            ($score->score > 1) ? $all_scores_are_valid = false : '';

        endforeach;

        return $all_scores_are_valid;
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The score is not valid';
    }
}
