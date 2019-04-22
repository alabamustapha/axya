<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'gender'   => 'required|in:Male,Female,Other',
            'dob'      => 'required|date|max:10',
            'terms'    => 'required|boolean',
            'region_id'=> 'required|integer|exists:regions,id',
            'city_id'  => 'required|integer|exists:cities,id',
        ]);

        $rules = app()->environment('testing')
            ? array_merge($rules, [])
            : array_merge($rules, [
                'password' => 'required|string|min:6|confirmed',
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
        return [
            'gender.required' => 'You must select your gender',
            'gender.in'       => 'You can only choose from the avaiable gender select options.',
            'dob.required'    => 'Date of birth is required.',
            'dob.date'        => 'Date of birth must be a date in the format: yyyy-mm-dd',
            'terms.required'  => 'You must accept the terms and conditions to be able to use our services.',
        ];
    }
}
