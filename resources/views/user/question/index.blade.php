@extends ('common.user')
@section ('content')

<h2 class="brand-header">質問一覧</h2>
<div class="main-wrap">
  {!! Form::open(['route' => ['question.index'], 'method' => 'GET', 'class' => 'category-id']) !!}
    <div class="btn-wrapper">
      <div class="search-box">
        {!! Form::input('text', 'search_word', !empty($inputs["search_word"]) ? $inputs["search_word"] : '', ['class' => 'form-control search-form', 'placeholder' => 'Search words...']) !!}
        {!! Form::button('<i class="fa fa-search" aria-hidden="true"></i>', ['class' => 'search-icon', 'type' => 'submit']) !!}
      </div>
      <a class="btn" href="{{ route('question.create') }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
      <a class="btn" href="{{ route('question.mypage', ['user_id' => Auth::id() ]) }}">
        <i class="fa fa-user" aria-hidden="true"></i>
      </a>
    </div>
    <div class="category-wrap">
      <div class="btn all" id="0">all</div>
      @foreach($categories as $category)
        <div class="btn {{ $category->name }}" id="{{ $category->id }}">{{ $category->name }}</div>
      @endforeach
      {!! Form::input('hidden', 'tag_category_id', '0', ['id' => 'category-val']) !!}
    </div>
  {!! Form::close() !!}
  <div class="content-wrapper table-responsive">
    <table class="table table-striped">
      <thead>
        <tr class="row">
          <th class="col-xs-1">user</th>
          <th class="col-xs-2">category</th>
          <th class="col-xs-6">title</th>
          <th class="col-xs-1">comments</th>
          <th class="col-xs-2"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($questions as $question)
          <tr class="row">
            <td class="col-xs-1"><img src="{{ $question->user->avatar }}" class="avatar-img"></td>
            <td class="col-xs-2">{{ $question->tagCategory->name }}</td>
            <td class="col-xs-6">{{ $question->title }}</td>
            <td class="col-xs-1"><span class="point-color">{{ count($question->comment) }}</span></td>
            <td class="col-xs-2">
              <a class="btn btn-success" href="{{ route('question.show', $question->id) }}">
                <i class="fa fa-comments-o" aria-hidden="true"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div aria-label="Page navigation example" class="text-center">
      @if (empty($inputs["tag_category_id"]) && empty($inputs["search_word"]))
        {{ $questions->links() }}
      @else
        {{ $questions->appends(['search_word' => $inputs["search_word"] ?? '' ])->appends(['tag_category_id' => $inputs["tag_category_id"]])->links() }}
      @endif
    </div>
  </div>
</div>

@endsection

