<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'type'      => 'required|in:Online,Home',
            'address'   => 'required_if:type,Home|string',
            'phone'     => 'required_if:type,Home|string',

            'doctor_id' => 'required|integer|exists:doctors,id',
            'patient_info' => 'required|string|max:1500',

            'day'       => 'required|date',
            'from'      => 'required|date_format:H:i',
            'to'        => 'required|date_format:H:i|after:from',
        ]);

        $rules = app()->environment('testing')
        # date_format:H:i not responding in testing thus needs to be seperated out.
            ? array_merge($rules, [])
            : array_merge($rules, [
                'from' => 'required',
                'to'   => 'required',
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
            'doctor_id.required'    => 'A doctor must be selected.',
            'doctor_id.exists'      => 'A valid doctor must be selected.',
            'from.date_format' => 'The start of an appointment must be in the format: 08:23 AM.',
            'to.date_format'   => 'The end of a schedule must be in the format: 10:23 PM.',
        ];
    }
}
