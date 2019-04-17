<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
        $rules = [];
        
        $rules = array_merge($rules, [
            'specialty_id'      => 'required|array',
            'specialty_id.*'    => 'required|integer|exists:specialties,id',
            'first_appointment' => 'required|date|before_or_equal:'. $date,
            'region_id'         => 'required|integer',// |exists:regions,id
            'city_id'           => 'required|integer',// |exists:cities,id

            'workplace'         => 'required|string',
            'workplace_address' => 'required|string',
            'workplace_start'   => 'required_with:workplace|date|before_or_equal:'. $date,
        ]);
        $rules = app()->environment('testing')
            ? array_merge($rules, [])
            : array_merge($rules, [
                'specialist_diploma'=> 'required|file|max:2000|mimetypes:application/pdf|mimes:pdf',//mtypes:,image/png,image/jpeg|mimes:,jpeg,png
                'competences'       => 'required|file|max:2000|mimetypes:application/pdf|mimes:pdf',//mtypes:,image/png,image/jpeg|mimes:,jpeg,png
                'malpraxis'         => 'required|file|max:2000|mimetypes:application/pdf|mimes:pdf',//mtypes:,image/png,image/jpeg|mimes:,jpeg,png

                'medical_college'   => 'required|file|max:2000|mimetypes:application/pdf|mimes:pdf',//mtypes:,image/png,image/jpeg|mimes:,jpeg,png
                'medical_college_expiry' => 'required_with:medical_college|date|after_or_equal:'. $date,
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
            //
        ];
    }
}
