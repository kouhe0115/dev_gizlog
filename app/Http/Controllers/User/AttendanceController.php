<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    private $attendance;
    
    /**
     * コンストラクター
     *
     * Attendance $attendance
     * @param Attendance $attendance
     */
    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }
    
    /**
     * 勤怠管理画面の表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $userId = Auth::id();
        $d = Carbon::now()->format('Y-m-d');
        $attendance = $this->attendance->where('date', $d)->where('user_id', $userId)->first();
        return view('user.attendance.index', compact('attendance'));
    }
    
    /**
     * 出勤時間の登録
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setStartAbsent(Request $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        $inputs['date'] = Carbon::now()->format('Y-m-d');
        $this->attendance->fill($inputs)->save();
        return redirect()->route('attendance');
    }
    
    /**
     * 退勤時間の登録
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setEndAbsent(Request $request, $id)
    {
        $inputs = $request->all();
        $this->attendance->find($id)->fill($inputs)->save();
        return redirect()->route('attendance');
    }
    
    /**
     * 欠席理由画面の表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAbsence()
    {
        return view('user.attendance.absence');
    }
    
    /**
     * 欠席、理由の登録
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setAbsence(Request $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        $inputs['absent_flg'] = 1;
        $inputs['date'] = Carbon::now()->format('Y-m-d');
        $this->attendance->fill($inputs)->save();
        return redirect()->route('attendance');
    }
    
    /**
     *ログイン中のユーザーの勤怠記録の表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

}
