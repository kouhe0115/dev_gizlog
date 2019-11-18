<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
            'start_time'      => 'sometimes|required',
            'end_time'        => 'sometimes|required',
            'request_content' => 'sometimes|required|max:500',
            'absent_reason'   => 'sometimes|required|max:500',
            'date'            => 'sometimes|before:now',
            'searchDate'      => 'sometimes|before:now',
        ];
    }

    public function messages()
    {
        return [
            'required'        => '入力必須の項目です',
            'max'             => ':max文字以内で入力してください。',
            'before:now'      => '今日以前で入力してください。',
        ];
    }
}

