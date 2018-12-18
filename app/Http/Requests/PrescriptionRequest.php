<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
            'appointment_id' => 'required|integer|exists:appointments,id',
            'usage'          => 'required|string',
            'comment'        => 'nullable|string',
            'drugs'          => 'required|array',
            // REQUIREDS
            // 'drugs.prescription_id'=> 'required|integer|exists:prescriptions,id',
            'drugs.*.name'           => 'required|string|max:100',
            'drugs.*.dosage'         => 'required|string',
            'drugs.*.usage'          => 'required|string',
            // NULLABLES
            'drugs.*.texture'        => 'nullable|string',
            'drugs.*.manufacturer'   => 'nullable|string',
            'drugs.*.comment'        => 'nullable|string',
        ];
    }
}
