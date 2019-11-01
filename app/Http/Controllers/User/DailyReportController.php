<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;
use Auth;
use App\Http\Requests\User\DailyReportRequest;

class DailyReportController extends Controller
{
    private $report;
    
    public function  __construct(DailyReport $report)
    {
        $this->middleware('auth');
        $this->report = $report;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $searchMonth = $request->input('search-month');
        
        if (!empty($searchMonth)) {
            $reports = $this->report->getByMonthReports($searchMonth, $userId);
        } else {
            $reports = $this->report->getByUserId($userId);
        }
        return view('user.daily_report.index', compact('reports', 'searchMonth'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.daily_report.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\DailyReportRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyReportRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();

        $this->report->create($inputs);
        return redirect()->route('report.index');
    }
    
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = $this->report->find($id);
        return view('user.daily_report.show', compact('report'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = $this->report->find($id);
        return view('user.daily_report.edit', compact('report'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\User\DailyReportRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DailyReportRequest $request, $id)
    {
        $inputs = $request->all();
        $this->report->find($id)->fill($inputs)->save();
        return redirect()->route('report.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->report->find($id)->delete();
        return redirect()->route('report.index');
    }
}
