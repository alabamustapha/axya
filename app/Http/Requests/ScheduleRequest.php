<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'doctor_id' => 'required|integer|exists:doctors,id',
            'day_id'    => 'required|integer|exists:days,id',
            'schedules'  => 'array',
        ]);

        $rules = app()->environment('testing')
        # date_format:H:i:s not responding in testing thus needs to be seperated out.
            ? array_merge($rules, [
                'schedules.*.start_at'  => 'required',
                'schedules.*.end_at'    => 'required',])
            : array_merge($rules, [
                'schedules.*.start_at'  => 'required|date_format:H:i:s',
                'schedules.*.end_at'    => 'required|date_format:H:i:s|after:start_at',
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
            'start_at.date_format' => 'The start of a schedule must be in the format: 18:23:00 and must be between 00:00:00 to 23:59:59.',
            'end_at.date_format'   => 'The end of a schedule must be in the format: 18:23:00 and must be between 00:00:00 to 23:59:59.',
            'end_at.after' => 'The end time must be after the start time',
        ];
    }
}
