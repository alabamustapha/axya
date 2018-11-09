<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkplaceRequest extends FormRequest
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
            'doctor_id'  => 'integer|exists:doctors,id',
            'name'       => 'required|string',
            'address'    => 'required|string',
            'start_date' => 'required|date|before_or_equal:'. $date,
            'end_date'   => 'nullable|date|after:start_date',
        ];
    }
}
