<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'start_time'  => 'required',
            'end_time'    => 'required',
            'date'        => 'required|date'
        ];
    }
    
    public function AttendanceTimeRequest()
    {
        return $this->only('start_time', 'end_time', 'date');
    }
}
