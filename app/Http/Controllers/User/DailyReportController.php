<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport as Report;

class DailyReportController extends Controller
{
    private $report;
    
    public function  __construct(Report $report)
    {
        $this->report = $report;
    }

    public function index()
    {
        $reports = $this->report->all();
        return view('user.daily_report.index', compact('reports'));
    }


    public function create()
    {
        return view('user.daily_report.create');
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('user.daily_report.show');
    }


    public function edit($id)
    {
        return view('user.daily_report.edit');
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
