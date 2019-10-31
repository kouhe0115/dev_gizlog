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

    public function index(Request $request)
    {
        $searchMonth = $request->input('search-month');
        if (!empty($searchMonth))
        {
            $reports = $this->report->where('user_id', Auth::id())->where('reporting_time', 'like', '%' . $searchMonth. '%')->orderBy('reporting_time', 'desc')->get();
            return view('user.daily_report.index', compact('reports', 'searchMonth'));
        } else {
            $reports = $this->report->getByUserId(Auth::id());
            return view('user.daily_report.index', compact('reports'));
        }
    }


    public function create()
    {
        return view('user.daily_report.create');
    }


    public function store(DailyReportRequest $request)
    {
        $input = $request->all();
        $this->report->fill($input)->save();
        return redirect()->route('report.index');
    }

    public function show($id)
    {
        $report = $this->report->find($id);
        return view('user.daily_report.show', compact('report'));
    }


    public function edit($id)
    {
        $report = $this->report->find($id);
        return view('user.daily_report.edit', compact('report'));
    }


    public function update(DailyReportRequest $request, $id)
    {
        $input = $request->all();
        $this->report->find($id)->fill($input)->save();
        return redirect()->route('report.index');
    }


    public function destroy($id)
    {
        $this->report->find($id)->delete();
        return redirect()->route('report.index');
    }
}
