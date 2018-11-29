<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkplaceUpdateRequest extends FormRequest
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
            'name'       => 'required|string',
            'address'    => 'required|string',
            'start_date' => 'required|date|before_or_equal:'. $date,
            'end_date'   => 'date|after:start_date',
            'current'    => 'boolean',
        ];
    }
}
