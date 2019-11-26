<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceModifyRequest extends FormRequest
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
            'request_content' => 'required|max:500',
            'searchDate'      => 'required|date|before:now',
        ];
    }
    
    public function ModifyRequest()
    {
        return $this->only('request_content', 'searchDate');
    }

    public function messages()
    {
        return [
            'required'        => '入力必須の項目です',
            'max'             => ':max文字以内で入力してください。',
            'before'          => '今日以前で入力してください。',
        ];
    }
}
