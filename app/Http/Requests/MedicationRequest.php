<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicationRequest extends FormRequest
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
            'title'            => 'required|string|max:100',
            'prescription_id'  => 'nullable|exists:prescriptions,id', 
            'appointment_id'   => 'nullable|exists:appointments,id', 
            'description'      => 'required|string|max:1000', 
            'start_date'       => 'required|date',
            'end_date'         => 'required|date:after,start_date',
            'notify_by'        => 'required|numeric', 
            'recurrence'       => 'required|numeric', 
            'recurrence_type'  => 'required|in:minutes,hours,days,weeks,months,years', 
        ]);

        $rules = app()->environment('testing')
            ? array_merge($rules, [])
            : array_merge($rules, [
                'start_time'   => 'required|date_format:H:i',
            ]);

        return $rules;
        
    }
}
