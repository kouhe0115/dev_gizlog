<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AttendanceAbsentRequest;
use App\Service\AdminAttendanceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAttendanceTimeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

/**
 * 勤怠管理者のメソッド
 *
 * Class AttendanceController
 * @package App\Http\Controllers\Admin
 */
class AttendanceController extends Controller
{
    /**
     * @var AdminAttendanceService
     */
    private $AdminAttendanceService;
    
    /**
     * AttendanceController constructor.
     * @param AdminAttendanceService $AdminAttendanceService
     */
    public function __construct(AdminAttendanceService $AdminAttendanceService)
    {
        $this->middleware('auth:admin');
        $this->AdminAttendanceService = $AdminAttendanceService;
    }
    
    /**
     * 一覧表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
//        $test = Redis::get('room01');
//        dd($test);
        $userInfos = $this->AdminAttendanceService->fetchAllUsersInfo();
        return view('admin.attendance.index', compact('userInfos'));
    }
    
    /**
     * 個別勤怠管理ページの表示
     *
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user($userId)
    {
        $userInfos = $this->AdminAttendanceService->fetchUserInfo($userId);
        $lateAbsentCount = $this->AdminAttendanceService->countAbsentLate($userInfos);
        return view('admin.attendance.user', compact('userInfos', 'lateAbsentCount'));
    }
    
    /**
     * 個別勤怠作成ページの表示
     *
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($userId)
    {
        $userInfos = $this->AdminAttendanceService->fetchUserInfo($userId);
        return view('admin.attendance.create', compact('userInfos'));
    }
    
    /**
     * 個別勤怠の新規作成処理
     *
     * @param AdminAttendanceTimeRequest $request
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminAttendanceTimeRequest $request, $userId)
    {
        $inputs = $request->attendanceTimeRequest();
        $this->AdminAttendanceService->registerAttendance($inputs, $userId);
        return redirect()->route('admin.attendance');
    }
    
    /**
     * 個別編集画面の表示
     *
     * @param $userId
     * @param $date
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($userId, $date)
    {
        $attendance = $this->AdminAttendanceService->fetchUserAttendanceByDate($userId, $date);
        return view('admin.attendance.edit', compact('attendance'));
    }
    
    /**
     * 個別勤怠の更新処理
     *
     * @param AdminAttendanceTimeRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminAttendanceTimeRequest $request, $id)
    {
        $inputs = $request->attendanceTimeRequest();
        $this->AdminAttendanceService->updateAttendance($id, $inputs);
        return redirect()->route('admin.attendance');
    }
    
    /**
     * 個別勤怠の欠席処理
     *
     * @param AttendanceAbsentRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setAbsent(AttendanceAbsentRequest $request ,$id)
    {
        $inputs = $request->only('date');
        $inputs['user_id'] = $id;
        $inputs['is_absent'] = true;
        $this->AdminAttendanceService->registerAbsent($inputs);
        return redirect()->route('admin.attendance');
    }
}
