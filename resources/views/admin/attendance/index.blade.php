@extends ('common.admin')
@section ('content')
  
  <h2 class="brand-header">勤怠情報</h2>
  
  <div class="main-wrap clearfix">
    
    <div class="btn-wrapper">
      <div class="my-info day-info">
        <p>想定出席人数</p>
        <div class="study-hour-box clearfix">
          <div class="userinfo-box"><i class="fa fa-user fa-2x" aria-hidden="true"></i></div>
          <p class="study-hour"><span>{{ count($userInfos) }}</span>人</p>
        </div>
      </div>
    </div>
    
    <div class="left-box">
      <div class="content-wrapper table-responsive">
        <table class="table">
          <caption><p>出社済み</p></caption>
          <thead>
          <tr class="row">
            <th class="col-xs-1"></th>
            <th class="col-xs-2">名前</th>
            <th class="col-xs-2">研修開始日</th>
            <th class="col-xs-3">出社時間</th>
            <th class="col-xs-2">修正申請</th>
            <th class="col-xs-2">詳細</th>
          </tr>
          </thead>
          <tbody>
          
          @foreach($userInfos as $userInfo)
            @if (!empty($userInfo->attendance) && !$userInfo->attendance->is_absent)
              <tr class="row">
                <td class="col-xs-1"><img src="{{ $userInfo->avatar }}" class="avatar-img"></td>
                <td class="col-xs-2">{{ $userInfo->name }}</td>
                <td class="col-xs-2">{{ $userInfo->created_at->format('Y/m/d') }}</td>
                <td class="col-xs-3">{{ $userInfo->attendance->start_time->format('H:i') }}</td>
                <td class="col-xs-2">{{ $userInfo->attendance->request_content ? 'あり' : '-' }}</td>
                <td class="col-xs-2">
                  <a href="{{ route('admin.attendance.user', $userInfo->id) }}" class="btn btn-sucssess">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
            @endif
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
    
    <div class="right-box">
      <div class="right-parts table-responsive attendance-table">
        <table class="table">
          <caption><p class="still">出社未登録</p></caption>
          <thead>
          <tr class="row">
            <th class="col-xs-1"></th>
            <th class="col-xs-7">名前</th>
            <th class="col-xs-4">詳細</th>
          </tr>
          </thead>
          <tbody>
          @foreach($userInfos as $userInfo)
            @if (empty($userInfo->attendance))
              <tr class="row">
                <td class="col-xs-1"><img src="{{ $userInfo->avatar }}" class="avatar-img"></td>
                <td class="col-xs-7">{{ $userInfo->name }}</td>
                <td class="col-xs-4">
                  <a href="{{ route('admin.attendance.user', $userInfo->id) }}" class="btn btn-sucssess">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
            @endif
          @endforeach
          </tbody>
        </table>
      </div>
      <div class="right-parts table-responsive attendance-table">
        <table class="table">
          <caption><p class="absence">欠席</p></caption>
          <thead>
          <tr class="row">
            <th class="col-xs-1"></th>
            <th class="col-xs-7">名前</th>
            <th class="col-xs-4">詳細</th>
          </tr>
          </thead>
          <tbody>
          @foreach($userInfos as $userInfo)
            @if (!empty($userInfo->attendance) && $userInfo->attendance->is_absent)
              <tr class="row">
                <td class="col-xs-1"><img src="{{ $userInfo->avatar }}" class="avatar-img"></td>
                <td class="col-xs-7">{{ $userInfo->name }}</td>
                <td class="col-xs-4">
                  <a href="{{ route('admin.attendance.user', $userInfo->id) }}" class="btn btn-sucssess">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
            @endif
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  
  </div>

@endsection


