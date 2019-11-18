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
      @if(isset($attendance->absent_flg) && $attendance->absent_flg === 1)
        <a class="button disabled">欠席</a>
      @elseif(empty($attendance->start_time) && empty($attendance->end_time))
        <a class="button start-btn" id="register-attendance" href=#openModal>出社時間登録</a>
      @elseif(!empty($attendance->start_time) && !empty($attendance->end_time))
        <a class="button disabled">退社済み</a>
      @elseif(!empty($attendance->start_time) && empty($attendance->end_time))
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
        <a class="at-btn my-list" href="{{ route('attendance.mypage', Auth::id()) }}">マイページ</a>
      </li>
    </ul>
  </div>

  <div id="openModal" class="modalDialog">
    <div>
      <div class="register-text-wrap"><p>{{ Carbon::now() }}</p></div>
      <div class="register-btn-wrap">
        @if (empty($attendance->start_time))
          {!! Form::open(['route' => ['attendance.setStartAbsent']]) !!}
          {!! Form::hidden('start_time', null, ['id' => 'date-time-target']) !!}
        @elseif (!empty($attendance->start_time) && empty($attendance->end_time))
          {!! Form::open(['route' => ['attendance.setEndAbsent', $attendance->id], 'method' => 'PUT']) !!}
          {!! Form::hidden('end_time', null, ['id' => 'date-time-target']) !!}
        @endif
        <a href="#close" class="cancel-btn">Cancel</a>
        {!! Form::submit('Yes', ['class' => 'yes-btn']) !!}
        {!! Form::close() !!}
      </div>
    </div>
  </div>

@endsection
