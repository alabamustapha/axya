<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateRequest extends FormRequest
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
            'available'      => 'required|boolean',
            'specialty_id'   => 'required|integer|exists:specialties,id',
            // // 'specialties'    => 'required|array|max:3',
            // // 'specialties.*'  => 'required|integer|exists:specialties,id',
            'workplace_id'   => 'required|integer|exists:workplaces,id',
            'phone'          => 'nullable|numeric|max:9999999999999999|unique:doctors,phone,'.auth()->id(),
            'email'          => 'nullable|email|max:255|unique:doctors,email,'.auth()->id(),
            'about'          => 'nullable|string|max:1500',
            'location'       => 'nullable|string|max:255',

            'main_language'  => 'required|integer',//|exists:languages,id',
            'second_language'=> 'nullable|integer',//|exists:languages,id',
            'other_languages'=> 'nullable|string|max:255',
            // Location
            'country_id'     => 'required|integer',//|exists:countries,id
            'state_id'       => 'nullable|integer',//|exists:states,id
            'home_address'   => 'nullable|string|max:255',
            'work_address'   => 'nullable|string|max:255',
            'location'       => 'nullable|string|max:255',
            // Work
            'session'        => 'required|integer',
            // Education
            'graduate_school'=> 'required|string|max:255',
            'degree'         => 'required|string|max:255',
            'residency'      => 'nullable|string|max:255',
        ]);

        $rules = app()->environment('testing')
            ? array_merge($rules, [
                'rate'       => 'required|numeric',
            ])
            : array_merge($rules, [
                'rate'       => 'required|numeric|between:5,1500.00',
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
                //
            ];
    }
}
