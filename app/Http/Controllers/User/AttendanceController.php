<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\AttendanceService;
use App\Http\Requests\User\AttendanceRequest;
use Auth;

class AttendanceController extends Controller
{
    private $attendanceService;

    /**
     * AttendanceController constructor.
     * @param AttendanceService $attendanceService
     */
    public function __construct(AttendanceService $attendanceService)
    {
        $this->middleware('auth');
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
        $attendance = $this->attendanceService->getTodayAttendance($userId);
        return view('user.attendance.index', compact('attendance'));
    }
    
    /**
     * 出勤時間の登録
     *
     * @param AttendanceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setStartAbsent(AttendanceRequest $request)
    {
        $inputs = $request->validated();
        $inputs['user_id'] = Auth::id();
        $this->attendanceService->setStartTime($inputs);
        return redirect()->route('attendance');
    }
    
    /**
     * 退勤時間の登録
     *
     * @param AttendanceRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setEndAbsent(AttendanceRequest $request, $id)
    {
        $inputs = $request->validated();
        $this->attendanceService->setEndTime($inputs, $id);
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
     * @param AttendanceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setAbsence(AttendanceRequest $request)
    {
        $inputs = $request->validated();
        $inputs['user_id'] = Auth::id();
        $inputs['absent_flg'] = 1;
        $this->attendanceService->setAbsence($inputs);
        return redirect()->route('attendance');
    }

    /**
     * 勤怠修正申請画面表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function modify()
    {
        return view('user.attendance.modify');
    }
    
    /**
     * 修正申請の登録
     *
     * @param AttendanceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createModify(AttendanceRequest $request)
    {
        $inputs = $request->validated();
        $inputs[(user_id)] = Auth::id();
        $this->attendanceService->setRequest($inputs);
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
        return view('user.attendance.mypage',
            compact('attendances', 'totalLearningTime', 'attendancesCount'));
    }
}
