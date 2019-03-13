<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentUploadRequest extends FormRequest
{
    // public $uploadFile;
    // public $fileMimeType;
    // public $isImage;
    // public $isVideo;

    // public function __construct()
    // {
    //     $this->uploadFile = request()->uploadFile;
    //     $this->fileMimeType = $this->uploadFile[0]->getMimeType();
    //     $this->isImage      = starts_with($this->fileMimeType, 'image/');
    //     $this->isVideo      = starts_with($this->fileMimeType, 'video/');
    // }

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
     *
     * # Video Length Validation: 
     * @link https://www.magutti.com/blog/laravel-custom-validation-validate-video-length.
     * @link https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
     * @link ...\vendor\fzaninotto\faker\src\Faker\Provider\File.php:$mimeTypes
     */
    public function rules()
    {
        $uploadFile = request()->uploadFile;
        if (! is_array($uploadFile)) {
            // The uploaded file variable is expected to be an array.
            return [ 'uploadFile' => 'required|array|max:5', ];
        }

        foreach ($uploadFile as $newFile) {

            $fileMimeType = $newFile->getMimeType();
            $isImage      = starts_with($fileMimeType, 'image/');
            $isVideo      = starts_with($fileMimeType, 'video/');


            if ( $isImage ) {
                return [
                    'uploadFile.*' => 'required|file|image|max:2000|mimes:jpeg,png|dimensions:min_width=300,min_height=300',
                    'caption'      => 'required_with:uploadFile|string|max:255',
                ];
            }
            elseif ( $isVideo ) {
                return [
                    'uploadFile.*' => 'required|file|max:2000|mimes:mp4,webm',
                    'caption'      => 'required_with:uploadFile|string|max:255',
                ];
            }
            else {
                return [
                    'uploadFile.*' => 'required|file|max:2000|mimes:pdf,txt',
                    'caption'      => 'required_with:uploadFile|string|max:255',
                ];
            }
        }
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        $uploadFile   = request()->uploadFile;
        // dd(request()->all());

        foreach ($uploadFile as $newFile) {

            $fileMimeType = $newFile->getMimeType();
            $isImage      = starts_with($fileMimeType, 'image/');
            $isVideo      = starts_with($fileMimeType, 'video/');

            if ( $isImage ) {
                return [
                    'uploadFile.mimes'      => 'Only jpeg and png formats are allowed.',
                    'uploadFile.dimensions' => 'Your image dimensions must have a minimum width of 300px and minimum height of 300px.',
                    'uploadFile.*.dimensions' => 'All images must have a minimum width: 300px and minimum height: 300px.',
                    'uploadFile.*.max'      => 'Image size must be a maximum of 2mb.',
                ];
            }
            elseif ( $isVideo ) {
                #  Video Length Validation: 
                // https://www.magutti.com/blog/laravel-custom-validation-validate-video-length.
                return [
                    'uploadFile.mimes' => 'Only mp4,webm formats are allowed.',
                    'uploadFile.*.max' => 'Video size must be a maximum of 2mb.',
                ];
            }
            else {
                return [
                    'uploadFile.mimes' => 'Only pdf and docx formats are allowed.',
                    'uploadFile.*.max' => 'File size must be a maximum of 2mb.',
                ];
            }
        }
    }
}
