<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminNotificationRequest extends FormRequest
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
            "as_notice"   => "boolean",
            "as_email"    => "boolean",
            "as_push"     => "boolean",
            "as_text"     => "boolean",
            "to"          => "required|in:Everyone,Admins,Doctors,Users",
            "region_id"   => "nullable|integer|exists:regions,id",
            "city_id"     => "nullable|integer|exists:cities,id",
            "searchEmail" => "nullable|email",
            "title"       => "required|string|max:120",
            "content"     => "required|string|max:450",
        ];
        // [
        //     'drugs'          => 'required|array',
        //     // REQUIREDS
        //     // 'drugs.prescription_id'=> 'required|integer|exists:prescriptions,id',
        //     'drugs.*.name'           => 'required|string|max:100',
        //     'drugs.*.dosage'         => 'required|string',
        //     'drugs.*.usage'          => 'required|string',
        //     // NULLABLES
        //     'drugs.*.texture'        => 'nullable|string',
        //     'drugs.*.manufacturer'   => 'nullable|string',
        //     'drugs.*.comment'        => 'nullable|string',
        // ]
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
