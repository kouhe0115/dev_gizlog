<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminAttendanceTimeRequest extends FormRequest
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
            'start_time' => ['required', 'string'],
            'end_time' => ['required', 'string'],
            'date' => [
                'required',
                'date',
                Rule::unique('attendances')->where(function ($query) {
//                  user_id が id な勤怠を取得してdateとinput('date')が一緒なら弾く
                    $query->where('user_id', $this->id);
                }),
            ],
        ];
    }
    
    public function messages()
    {
        return [
            'required' => '必須！！',
            'unique' => 'その日付は存在しています。',
        ];
    }
    
    public function attendanceTimeRequest()
    {
        return $this->only('start_time', 'end_time', 'date');
    }
}
