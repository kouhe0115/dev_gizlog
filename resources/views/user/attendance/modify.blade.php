@extends ('common.user')
@section ('content')

<h2 class="brand-header">修正申請</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['attendance.createModify']]) !!}
    <div class="form-group form-size-small {{ $errors->has('searchDate') ? 'has-error' : '' }}">
      {!! Form::input('date', 'searchDate', Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) !!}
      <span class="help-block">{{ $errors->first('searchDate') }}</span>
    </div>
    <div class="form-group {{ $errors->has('request_content') ? 'has-error' : '' }}">
      {!! Form::textarea('request_content', null, ['class' => 'form-control', 'placeholder' => '修正申請の内容を入力してください']) !!}
      <span class="help-block">{{ $errors->first('request_content') }}</span>
    </div>
    {!! Form::submit('申請', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

