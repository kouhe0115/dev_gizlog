<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Auth;
use App\Service\AttendanceService;

class AttendanceController extends Controller
{
    private $attendance;
    private $attendanceService;
    
    /**
     * AttendanceController constructor.
     * @param Attendance $attendance
     * @param AttendanceService $attendanceService
     */
    public function __construct(Attendance $attendance, AttendanceService $attendanceService)
    {
        $this->attendance = $attendance;
        $this->attendanceService = $attendanceService;
    }
    
    /**
     * 勤怠管理画面の表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $userId = Auth::id();
        $attendance = $this->attendanceService->getByTodayAttendance($userId);
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
        $inputs['date'] = $this->attendanceService->getNowDate();
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
        $inputs['date'] = $this->attendanceService->getNowDate();
        $this->attendance->fill($inputs)->save();
        return redirect()->route('attendance');
    }
    
    /**
     * 修正申請画面表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modify()
    {
        return view('user.attendance.modify');
    }
    
    /**
     * 修正申請を登録する
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createModify(Request $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();
        $attendance = $this->attendanceService->getAttendanceBySearchDate($inputs);
        $attendance->fill($inputs)->save();
        return redirect()->route('attendance');
    }
    
    /**
     * ログイン中のユーザーの勤怠記録の表示
     *
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mypage($userId)
    {
        $attendances = $this->attendanceService->getByUserId($userId);
        $attendancesCount = $this->attendanceService->getAttendancesCount($userId);
        $totalLearningTime = $this->attendanceService->getTotalLearningTime($userId);
        return view('user.attendance.mypage', compact('attendances', 'totalLearningTime', 'attendancesCount'));
    }
}
