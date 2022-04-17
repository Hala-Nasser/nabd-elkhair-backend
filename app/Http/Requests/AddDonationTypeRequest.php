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
            //'name' => 'required|string|unique:donation_types,id,' . $this->id,
            'name'=>'required|string|unique:donation_types,name,'.$this->id,
            'image'=> 'nullable|required_if:id,null|image',
        ];
        
    }

    public function messages(){

        return [
            'name.required'=> 'الاسم مطلوب',
            'name.string'=> 'يجب ان يكون الاسم نص',
            'name.unique'=> 'يجب ان يكون الاسم فريد',
            'image.image'=> 'الرجاء اختيار صورة',
            ];

    }
}
