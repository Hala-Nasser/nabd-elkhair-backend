<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDonationTypeRequest extends FormRequest
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
            'name' => 'required|string',
            'image'=> 'required|image',
        ];
        
    }

    public function messages(){

        return [
            'name.required'=> 'الاسم مطلوب',
            'name.string'=> 'يجب ان يكون الاسم نص',
            'image.required'=> 'الصورة مطلوبة',
            'image.image'=> 'الرجاء اختيار صورة',
            ];

    }
}
