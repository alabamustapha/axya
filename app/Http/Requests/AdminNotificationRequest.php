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
        request()->region_id = (request()->region_id > 0) ? request()->region_id : null;
        // dd(request()->region_id);
        return [
            "as_notice"   => "boolean|required_without_all:as_email,as_push,as_text",
            "as_email"    => "boolean",
            "as_push"     => "boolean",
            "as_text"     => "boolean",
            "to"          => "required|in:Everyone,Admins,Doctors,Users",
            "region_id"   => "nullable|integer",//|exists:regions,id|required_with:to.Doctors|required_with:to.Users
            "city_id"     => "nullable|integer|exists:cities,id",//|required_with:region_id
            "search_email" => "nullable|string",
            "title"       => "required|string|max:50",
            "content"     => "required|string|max:450",
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
            "as_notice.required_without_all" => 'A "Send As" option must be selected.',
        ];
    }
}
