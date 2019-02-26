<?php

namespace App\Http\Requests;

use App\Rules\IsbnRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveBookRequest extends FormRequest
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
            'isbn' => ['required', 'unique:books', new IsbnRule],
            'title' => 'required|max:200',
            'year' => 'required|integer'
        ];
    }
}
