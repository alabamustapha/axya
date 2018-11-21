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
        return [
            'doctor_id' => 'required|integer|exists:doctors,id',
            'day'       => 'required|date',
            'from_time' => 'required|date_format:H:i:s',
            'to_time'   => 'required|date_format:H:i:s',
            'patient_info' => 'required|string|max:1500',
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
            'doctor_id.required'=> 'A doctor must be selected.',
            'doctor_id.exists'  => 'A valid doctor must be selected.',
            'from_time.date_format' => 'The start of an appointment must be in the format: 18:23:00 and must be between 00:00:00 to 23:59:59.',
            'to_time.date_format'   => 'The end of a schedule must be in the format: 18:23:00 and must be between 00:00:00 to 23:59:59.',
        ];
    }
}
