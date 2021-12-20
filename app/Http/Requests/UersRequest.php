<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UersRequest extends FormRequest
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
           'name'=>'required|unique:users',
            'email'=>'required|unique:users',

        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'يجب ادخال الايميل',
            'name.required'=>'يجب ادخال الاسم',
            'email.unique'=>'هذا الايميل موجود ',
            'name.unique'=>'هذا الاسم موجود'

        ];
    }

}
