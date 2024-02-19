<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CategoriesValidation;

class GetMetricsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        return [
            'url' => ['required', 'url:http,https', 'max:255'],
            'strategy' => ['required', 'numeric', 'exists:strategy,id'],
            'categories' => ['required', new CategoriesValidation],
        ];
    }
}