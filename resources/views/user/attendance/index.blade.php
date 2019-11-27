@extends ('common.user')
@section ('content')
  
  <h2 class="brand-header">勤怠登録</h2>
  
  <div class="main-wrap">
    <div id="clock" class="light">
      <div class="display">
        <div class="weekdays"></div>
        <div class="today"></div>
        <div class="digits"></div>
      </div>
    </div>
    
    <div class="button-holder">
      @if($status === 'absent')
        <a class="button disabled">欠席</a>
      @elseif($status === 'setStartTime')
        <a class="button start-btn" id="register-attendance" href=#openModal>出社時間登録</a>
      @elseif($status === 'leaving')
        <a class="button disabled">退社済み</a>
      @elseif($status === 'setEndTime')
        <a class="button end-btn" id="register-attendance" href=#openModal>退社時間登録</a>
      @endif
    </div>
    
    <ul class="button-wrap">
      <li>
        <a class="at-btn absence" href="/attendance/absence">欠席登録</a>
      </li>
      <li>
        <a class="at-btn modify" href="/attendance/modify">修正申請</a>
      </li>
      <li>
        <a class="at-btn my-list" href="{{ route('attendance.mypage') }}">マイページ</a>
      </li>
    </ul>
  </div>
  
  <div id="openModal" class="modalDialog">
    <div>
      <div class="register-text-wrap"><p>{{ Carbon::now() }}</p></div>
      <div class="register-btn-wrap">
        @if (empty($attendance->start_time))
          {!! Form::open(['route' => ['attendance.setStartTime']]) !!}
          {!! Form::hidden('start_time', null, ['id' => 'date-time-target']) !!}
        @elseif (!empty($attendance->start_time) && empty($attendance->end_time))
          {!! Form::open(['route' => ['attendance.setEndTime', $attendance->id], 'method' => 'PUT']) !!}
          {!! Form::hidden('end_time', null, ['id' => 'date-time-target']) !!}
        @endif
        <a href="#close" class="cancel-btn">Cancel</a>
        {!! Form::submit('Yes', ['class' => 'yes-btn']) !!}
        {!! Form::close() !!}
      </div>
    </div>
  </div>

@endsection
