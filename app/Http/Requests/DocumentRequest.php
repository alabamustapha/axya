<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
        // https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
        return [
            'user_id'           => 'required|integer|exists:users,id',
            'name'              => 'nullable|string',
            'description'       => 'nullable|string',
            'url'               => 'required|file|max:2000|mimetypes:application/pdf,image/png,image/jpeg,video/mp4|mimes:pdf,jpeg,png,mp4',// docx/video/ mp4?etc
            'documentable_id'   => 'required|integer',
            'documentable_type' => 'required|string',
            'issued_date'       => 'nullable|date',
            'expiry_date'       => 'nullable|date',
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
            //
        ];
    }
}
