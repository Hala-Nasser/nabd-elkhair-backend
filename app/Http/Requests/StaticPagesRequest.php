<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaticPagesRequest extends FormRequest
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
            'content'=> 'required|string',
            'title' => 'required|string',
            'image' => 'required|image',
        ];
        
    }

    public function messages(){

        return [
            'content.required'=> 'المحتوى مطلوب',
            'content.string'=> 'يجب ان يكون المحتوى نص',
            'title.required'=> 'العنوان مطلوب',
            'title.string'=> 'يجب ان يكون العنوان نص',
            'image.required'=> 'الصورة مطلوبة',
            'image.image'=> 'الرجاء اختيار صورة',
            ];

    }
}
