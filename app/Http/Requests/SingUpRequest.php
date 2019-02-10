<?php

namespace App\Http\Requests;
use Validator;
use Illuminate\Foundation\Http\FormRequest;

class SingUpRequest extends FormRequest
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

            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required',

        ];
    }


    public function messages()
    {
        return [
            // 'email.required' => '이메일을 입력해 주세요.',
            'email.unique'  => '이미 사용중인 이메일 입니다.',
            'email.email'  => '이메일 형식으로 입력해주세요.',
            // 'password.required' => '비밀번호를 입력해 주세요.', 
            'password.confirmed' => '비밀번호를 동일하게 입력해주세요.'
            // 'name.required' => '이름 입력해 주세요.',
            // 'phone.required' => '전화번호를 입력해주세요.',

        ];
    }


}
