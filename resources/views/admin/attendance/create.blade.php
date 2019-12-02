@extends ('common.admin')
@section ('content')
  
  <h2 class="brand-header">個別勤怠作成</h2>
  <div class="main-wrap">
    <div class="user-info-box clearfix">
      <div class="left-info">
        <img src="{{ $userInfos->avatar }}">
        <p class="user-name">{{ $userInfos->name }}</p>
        <i class="fa fa-envelope-o" aria-hidden="true"><p class="user-email">{{ $userInfos->email }}</p></i>
      </div>
      <div class="right-info">
        <div class="my-info">
          <p>研修開始日</p>
          <div class="study-hour-box clearfix">
            <p class="study-hour study-date"><span>{{ $userInfos->created_at->format('Y/m/d') }}</span></p>
          </div>
        </div>
      </div>
    </div>
    <div class="attendance-modify-box">
      {!! Form::open(['route' => ['admin.attendance.store', $userInfos->id]]) !!}
      <div class="form-group date-form">
        <input class="form-control" name="" type="date">
      </div>
      <div class="form-group">
        {!! Form::input('time', 'start_time', null, ['class' => 'form-control']) !!}
      </div>
      <p class="to-time">to</p>
      <div class="form-group">
        {!! Form::input('time', 'end_time',  null, ['class' => 'form-control']) !!}
      </div>
      {!! Form::hidden('date', Carbon::now()->format('Y-m-d')) !!}
      {!! Form::button('作成', ['type' => 'submit', 'class' => "btn btn-modify"]) !!}
      {!! Form::close() !!}
      
      {!! Form::open(['route' => ['admin.attendance.setAbsent', $userInfos->id], 'method' => 'PUT']) !!}
      {!! Form::button('欠席', ['type' => 'submit', 'class' => "btn btn-danger"]) !!}
      {!! Form::close() !!}
    </div>
  </div>

@endsection



