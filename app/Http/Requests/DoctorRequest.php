<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
        $date = date('Y-m-d');
        return [
            'id'          => 'required|integer|exists:users,id',
            'user_id'     => 'required|integer|exists:users,id',
            'specialty_id'=> 'required|integer|exists:specialties,id',
            'first_appointment'=> 'required|date|before_or_equal:'. $date,
            'slug'        => 'required|string|exists:users,slug',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            //
        ];
    }
}
