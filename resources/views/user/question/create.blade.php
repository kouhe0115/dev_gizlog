@extends ('common.user')
@section ('content')
  
<h2 class="brand-header">質問投稿</h2>
<div class="main-wrap">
  <div class="container">
    {!! Form::open(['route' => ['question.confirm'], 'class' => 'category-id']) !!}
      <div class="form-group {{ $errors->has('tag_category_id') ? 'has-error' : '' }}">
        {!! Form::select('tag_category_id',  $categories, null, ['id' => 'pref_id', 'class' => 'form-control selectpicker form-size-small', 'placeholder' => 'Select category']) !!}
        <span class="help-block">{{ $errors->first('tag_category_id') }}</span>
      </div>
      <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        {!! Form::input('text', 'title', null, ['class' => 'form-control', 'placeholder' => 'title']) !!}
        <span class="help-block">{{ $errors->first('title') }}</span>
      </div>
      <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
        {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Please write down your question here...']) !!}
        <span class="help-block">{{ $errors->first('content') }}</span>
      </div>
      {!! Form::input('submit', 'confirm', 'create', ['class' => 'btn btn-success pull-right']) !!}
      {!! Form::close() !!}
  </div>
</div>

@endsection
