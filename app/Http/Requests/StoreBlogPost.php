<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
        //第二种验证方法
        return [
            'name' => 'required|unique:student|max:50',
            'age' => 'required|numeric',
            ];
    }
    public function messages(){
        return [
            'name.required'=>'姓名不能为空',
            'name.unique'=>'格式错误',
           'age.required'=>'年龄不能为空'
        ];
       }
  
}
