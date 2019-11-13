@extends ('common.user')
@section ('content')

<h1 class="brand-header">質問詳細</h1>
<div class="main-wrap">
  <div class="panel panel-success">
    <div class="panel-heading">
      <img src="{{ $question->user->avatar }}" class="avatar-img">
      <p>&nbsp;{{ $question->user->name }} さんの質問&nbsp;&nbsp;({{ $question->tagCategory->name }})</p>
      <p class="question-date">{{ $question->created_at->format('Y-m-d m:i') }}</p>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <tbody>
          <tr>
            <th class="table-column">Title</th>
            <td class="td-text">{{ $question->title }}</td>
          </tr>
          <tr>
            <th class="table-column">Question</th>
            <td class='td-text'>{!!  nl2br(e($question->content)) !!}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="comment-list">
    @foreach ($question->comments as $comment)
      <div class="comment-wrap">
        <div class="comment-title">
          <img src="{{ $comment->user->avatar }}" class="avatar-img">
          <p>{{ $comment->user->name }}</p>
          <p class="comment-date">{{ $comment->created_at->format('Y-m-d m:i') }}</p>
        </div>
        <div class="comment-body">{!!  nl2br(e($comment->comment)) !!}</div>
      </div>
    @endforeach
  </div>
  <div class="comment-box">
    {!! Form::open(['route' => ['question.commentStore']]) !!}
      {!! Form::hidden('question_id', $question->id) !!}
      {!! Form::hidden('user_id', Auth::id()) !!}
      <div class="comment-title">
        <img src="{{ $question->user->avatar }}" class="avatar-img"><p>コメントを投稿する</p>
      </div>
      <div class="comment-body {{ $errors->has('comment') ? 'has-error' : '' }}">
        {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'Add your comment...', 'cols' => '50', 'rows' => '10']) !!}
        <span class="help-block">{{ $errors->first('comment') }}</span>
      </div>
      <div class="comment-bottom">
        {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i>', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection
