<?php

namespace App\Http\Controllers\Admin;

use App\Service\AdminAttendanceService;
use App\Models\User;
use Illuminate\Http\Request;
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
    
    public function user($userId)
    {
        $userInfos = $this->user->find($userId);
        $lateCount = $this->AdminAttendanceService->countLate($userInfos);
        return view('admin.attendance.user', compact('userInfos', 'lateCount'));
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.attendance.create');
    }
    
    public function edit($userId)
    {
        $userInfos = $this->user->find($userId);
        return view('admin.attendance.edit', compact('userInfos'));
    }
    
    public function update(AdminAttendanceTimeRequest $request, $id)
    {
        $strTime = $request->AttendanceTimeRequest();
        $this->AdminAttendanceService->attendanceUpdateByUserId($id, $strTime);
        return redirect()->route('admin.attendance');
    }
}