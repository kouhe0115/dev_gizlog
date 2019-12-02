@extends ('common.admin')
@section ('content')
  
  <h2 class="brand-header">個別勤怠編集</h2>
  <div class="main-wrap">
    <div class="user-info-box clearfix">
      <div class="left-info">
        <img src="{{ $attendance->user->avatar }}">
        <p class="user-name">{{ $attendance->user->name }}</p>
        <i class="fa fa-envelope-o" aria-hidden="true"><p class="user-email">{{ $attendance->user->email }}</p></i>
      </div>
      <div class="right-info">
        <div class="my-info day-info">
          <p>編集日</p>
          <div class="study-hour-box clearfix">
            <div class="userinfo-box"><i class="fa fa-calendar fa-2x" aria-hidden="true"></i></div>
            <p class="study-hour study-date"><span>{{ $attendance->date->format('m/d') }}</span></p>
          </div>
        </div>
        <div class="my-info">
          <p>研修開始日</p>
          <div class="study-hour-box clearfix">
            <p class="study-hour study-date"><span>{{ $attendance->user->created_at->format('Y/m/d') }}</span></p>
          </div>
        </div>
      </div>
    </div>
    @if ($attendance->is_request)
      <div class="request-box">
        <div class="request-title">
          <img src="{{ $attendance->user->avatar }}"
               class="avatar-img">
          <p>修正申請内容</p>
        </div>
        <div class="request-content">
          {{ $attendance->request_content }}
        </div>
      </div>
    @endif
    <div class="attendance-modify-box">
      {!! Form::open(['route' => ['admin.attendance.update', $attendance->id], 'method' => 'PUT']) !!}
      <div class="form-group">
        {!! Form::input('time', 'start_time', $attendance->start_time ? $attendance->start_time->format('H:i') : '', ['class' => 'form-control']) !!}
        <span class="help-block"></span>
      </div>
      <p class="to-time">to</p>
      <div class="form-group">
        {!! Form::input('time', 'end_time', $attendance->end_time ? $attendance->end_time->format('H:i') : '', ['class' => 'form-control']) !!}
        <span class="help-block"></span>
      </div>
      {!! Form::hidden('date', $attendance->date->format('Y-m-d')) !!}
      {!! Form::button('修正',  ['type' => 'submit', 'class' => "btn btn-modify"]) !!}
      {!! Form::close() !!}
      
      {!! Form::open(['route' => ['admin.attendance.setAbsent', $attendance->id], 'method' => 'PUT']) !!}
      {!! Form::button('欠席', ['type' => 'submit', 'class' => "btn btn-danger"]) !!}
      {!! Form::close() !!}
    </div>
  </div>

@endsection

