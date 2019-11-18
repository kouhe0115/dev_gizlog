@extends ('common.user')
@section ('content')

<h2 class="brand-header">欠席登録</h2>
<div class="main-wrap">
  <div class="container">
{{--    <form>--}}
{{--      <div class="form-group">--}}
{{--        <textarea class="form-control" placeholder="欠席理由を入力してください。" name="" cols="50" rows="10"></textarea>--}}
{{--      </div>--}}
{{--      <input name="confirm" class="btn btn-success pull-right" type="submit" value="登録">--}}
{{--    </form>--}}
  
    {!! Form::open(['route' => ['attendance.setAbsence']]) !!}
      <div class="form-group">
        {!! Form::textarea('absent_reason', null, ['class' => 'form-control', 'placeholder' => '欠席理由を入力してください']) !!}
      </div>
      {!! Form::submit('登録', ['class' => 'btn btn-success pull-right']) !!}
    {!! Form::close() !!}
  </div>
</div>

@endsection

