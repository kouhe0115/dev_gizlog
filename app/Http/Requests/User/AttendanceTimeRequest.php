<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceTimeRequest extends FormRequest
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
            'start_time'      => 'sometimes|date|before:now',
            'end_time'        => 'sometimes|date|before:now',
        ];
    }
    
    
    public function AttendanceStartTimeRequest()
    {
        return $this->only('start_time', 'date');
    }
    
    public function AttendanceEndTimeRequest()
    {
        return $this->only('end_time');
    }
}
