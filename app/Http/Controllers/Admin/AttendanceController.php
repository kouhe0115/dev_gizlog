<?php

namespace App\Http\Controllers\Admin;

use App\Service\AdminAttendanceService;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAttendanceTimeRequest;

/**
 * 勤怠管理者のメソッド
 *
 * Class AttendanceController
 * @package App\Http\Controllers\Admin
 */
class AttendanceController extends Controller
{
    /**
     * @var
     */
    private $user;
    /**
     * @var AdminAttendanceService
     */
    private $AdminAttendanceService;
    
    /**
     * AttendanceController constructor.
     * @param User $user
     * @param AdminAttendanceService $AdminAttendanceService
     */
    public function __construct(User $user, AdminAttendanceService $AdminAttendanceService)
    {
        $this->user = $user;
        $this->AdminAttendanceService = $AdminAttendanceService;
    }
    
    /**
     * 一覧表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $userInfos = $this->AdminAttendanceService->fetchUserInfo();
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
        $userInfos = $this->user->find($userId);
        $lateCount = $this->AdminAttendanceService->countLate($userInfos);
        return view('admin.attendance.user', compact('userInfos', 'lateCount'));
    }
    
    /**
     * 個別勤怠作成ページの表示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($userId)
    {
        $userInfos = $this->user->find($userId);
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
        $inputs = $request->AttendanceTimeRequest();
        $inputs['user_id'] = $userId;
        $this->AdminAttendanceService->registerAttendance($inputs);
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
        $attendance = $this->AdminAttendanceService->fetchAttendance($userId, $date);
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
        $inputs = $request->AttendanceTimeRequest();
        $this->AdminAttendanceService->attendanceUpdateByUserId($id, $inputs);
        return redirect()->route('admin.attendance');
    }
    
    /**
     * 個別勤怠の論理削除処理
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $this->AdminAttendanceService->attendanceUpdateIsDelete($id);
        return redirect()->route('admin.attendance');
    }
}