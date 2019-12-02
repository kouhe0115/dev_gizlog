@extends ('common.admin')
@section ('content')
  
  <h2 class="brand-header">個別勤怠管理</h2>
  <div class="main-wrap">
    <div class="user-info-box clearfix">
      <div class="left-info">
        <img src="{{ $userInfos->avatar }}">
        <p class="user-name">{{ $userInfos->name }}</p>
        <i class="fa fa-envelope-o" aria-hidden="true"><p class="user-email">{{ $userInfos->email }}</p></i>
      </div>
      <div class="right-info">
        <div class="my-info absence-info">
          <p>欠席回数</p>
          <div class="study-hour-box clearfix">
            <div class="userinfo-box"><i class="fa fa-ban fa-2x" aria-hidden="true"></i></div>
            <p class="study-hour"><span>{{ $lateAbsentCount['absentCount'] }}</span>回</p>
          </div>
        </div>
        <div class="my-info day-info">
          <p>遅刻回数</p>
          <div class="study-hour-box clearfix">
            <div class="userinfo-box"><i class="fa fa-clock-o fa-2x" aria-hidden="true"></i></div>
            <p class="study-hour"><span>{{ $lateAbsentCount['lateCount'] }}</span>回</p>
          </div>
        </div>
        <div class="my-info">
          <p>研修開始日</p>
          <div class="study-hour-box clearfix">
            <p class="study-hour study-date"><span>{{ $userInfos->created_at->format('Y/m/d') }}</span></p>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-wrapper">
      <a href="{{ route('admin.attendance.create', $userInfos->id) }}" class="btn btn-icon">
        <i class="fa fa-plus" aria-hidden="true"></i>
      </a>
    </div>
    <div class="content-wrapper table-responsive">
      <table class="table">
        <thead>
        <tr class="row">
          <th class="col-xs-1">日付</th>
          <th class="col-xs-1">曜日</th>
          <th class="col-xs-2">状態</th>
          <th class="col-xs-2">出社時間</th>
          <th class="col-xs-2">退社時間</th>
          <th class="col-xs-2">修正申請</th>
          <th class="col-xs-2">修正</th>
        </tr>
        </thead>
        <tbody>
        @foreach($userInfos->allattendance as $attendance)
          <tr class="row {{ $attendance->is_absent ? 'absent-row' : '' }}">
            <td class="col-xs-1">{{ $attendance->date ? $attendance->date->format('m/d') : '-' }}</td>
            <td class="col-xs-1">{{ $attendance->date ? $attendance->date->format('D') : '-' }}</td>
            <td class="col-xs-2">@if($attendance->is_absent) 欠席 @elseif(is_null($attendance->end_time))
                研修中 @elseif(!$attendance->is_absent) 出社 @endif</td>
            <td class="col-xs-2">{{ $attendance->start_time ? $attendance->start_time->format('H:i') : '-' }}</td>
            <td class="col-xs-2">{{ $attendance->end_time ? $attendance->end_time->format('H:i') : '-' }}</td>
            <td class="col-xs-2"><span class="{{ $attendance->is_request ? 'attention' : '' }}">{{ $attendance->is_request ? 'あり' : '-' }}</span></td>
            <td class="col-xs-2">
              <a href="{{ route('admin.attendance.edit', [$userInfos->id, $attendance->date->format('Y-m-d')]) }}"
                 class="btn btn-sucssess btn-small">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection

