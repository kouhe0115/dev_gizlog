@extends ('common.user')
@section ('content')

<h2 class="brand-header">修正申請</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['attendance.createModify']]) !!}
    <div class="form-group form-size-small">
      {!! Form::input('date', 'searchDate', Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::textarea('request_content', null, ['class' => 'form-control', 'placeholder' => '修正申請の内容を入力してください']) !!}
    </div>
    {!! Form::submit('申請', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

