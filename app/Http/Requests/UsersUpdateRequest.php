<?php

namespace App\Http\Requests;

use App\Country;
use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateRequest extends FormRequest
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
        $rules = [];

        $rules = array_merge($rules, [
                'name'      => 'required|string|max:255', 
                // 'email'     => 'required|max:255|email|unique:users,email,'.auth()->id(), // Use 3rd party service to ping for correct email addresses
                'phone'     => 'nullable|numeric|max:9999999999999999|unique:users,phone,'.auth()->id(), //|digits:11 
                'dob'       => 'required|date|max:10',
                'gender'   => 'required|in:Male,Female,Other',
                'weight'   => 'nullable|between:0,999.99',
                'height'   => 'nullable|between:0,99.99',
                'address'   => 'nullable|string',
            ]);

        return $rules;
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return 
            [
                'gender.required' => 'You must select your gender',
                'gender.in'       => 'You can only choose from the avaiable gender select options.',
            ];
    }
}
