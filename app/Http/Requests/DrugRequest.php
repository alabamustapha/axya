<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DrugRequest extends FormRequest
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
            // 'prescription_id'=> 'required|integer|exists:appointments,id',
            'name'           => 'required|string|max:100',
            'dosage'         => 'required|string',
            'usage'          => 'required|string',
            'texture'        => 'nullable|string',
            'manufacturer'   => 'nullable|string',
            'comment'        => 'nullable|string',
        ];
    }
}
