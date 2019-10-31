@extends ('common.user')
@section ('content')
	
	<h2 class="brand-header">日報編集</h2>
  <div class="main-wrap">
		<div class="container">
			{!! Form::open(['route' => ['report.update', $report->user_id], 'method' => 'PUT']) !!}
        {!! Form::input('hidden', 'user_id', Auth::id(), ['class' => 'form-control']) !!}
        <div class="form-group form-size-small {{ $errors->has('reporting_time') ?  'has-error' : '' }}">
          {!! Form::input('date', 'reporting_time', $report->reporting_time->format('Y-m-d'), ['class' => 'form-control']) !!}
          @if($errors->has('reporting_time'))
            <span class="help-block">{{ $errors->first('reporting_time') }}</span>
          @endif
        </div>
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
          {!! Form::input('text', 'title', $report->title, ['class' => 'form-control', 'placeholder' => 'Title']) !!}
          @if($errors->has('title'))
            <span class="help-block">{{ $errors->first('title') }}</span>
          @endif
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
          {!! Form::textarea('content', $report->content, ['class' => 'form-control', 'placeholder' => 'Content', 'cols' => '50', 'rows' => '10']) !!}
          @if($errors->has('content'))
            <span class="help-block">{{ $errors->first('content') }}</span>
          @endif
        </div>
        {!! Form::submit('UPDATE', ['class' => 'btn btn-success pull-right']) !!}
			{!! Form::close() !!}
		</div>
	</div>

@endsection
