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
                'graduate_school'=> 'nullable|string',
                'available'      => 'boolean',
                'specialties'    => 'required|array|max:3',
                'specialties.*'  => 'required|integer|exists:specialties,id',
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
