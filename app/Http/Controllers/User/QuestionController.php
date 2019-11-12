<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CommentRequest;
use App\Http\Requests\User\QuestionsRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Question;
use App\Models\TagCategory;
use Auth;

class QuestionController extends Controller
{
    private $question;
    private $category;
    private $comment;
    
    /**
     * コンストラクタ
     *
     * @param Question $question
     * @param TagCategory $category
     * @param Comment $comment
     */
    public function __construct(Question $question, TagCategory $category, Comment $comment)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->category = $category;
        $this->comment = $comment;
    }
    
    /**
     * 一覧画面の表示
     *
     * @param  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputs = $request->all();
//        dd($inputs);
        $questions = $this->question->getQuestion($inputs);
        $categories = $this->category->get();
        return view('user.question.index', compact('questions', 'categories', 'inputs'));
    }
    
    /**
     * 新規作成画面の表示
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->get()->pluck('name', 'id')->prepend('Select category');
        return view('user.question.create', compact('categories'));
    }

    /**
     * 新規登録機能
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {
        $inputs = $request->validated();
        $inputs['user_id'] = Auth::id();
        $this->question->create($inputs);
        return redirect()->route('question.index');
    }

    /**
     * 詳細画面の表示
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->question->find($id);
        return view('user.question.show', compact('question'));
    }

    /**
     * 編集画面の表示
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->question->find($id);
        $categories = $this->category->get()->pluck('name', 'id')->prepend('Select category');
        return view('user.question.edit', compact('question', 'categories'));
    }

    /**
     * 質問の更新処理
     *
     * @param  QuestionsRequest  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionsRequest $request)
    {
        $inputs = $request->validated();
        $this->question->find($inputs['question_id'])->update($inputs);
        return redirect()->route('question.index');
    }

    /**
     * 質問削除機能
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->question->find($id)->delete();
        return redirect()->route('question.index');
    }
    
    /**
     * 確認画面を表示
     *
     * @param  QuestionsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function confirm(QuestionsRequest $request)
    {
        $inputs = $request->validated();
        $categoryName = $this->category->find($inputs['tag_category_id'])->name;
        return view('user.question.confirm', compact('inputs', 'categoryName'));
    }
    
    /**
     * コメント登録処理
     *
     * @param  CommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function commentStore(CommentRequest $request)
    {
        $inputs = $request->validated();
        $this->comment->create($inputs);
        return redirect()->route('question.index');
    }
    
    /**
     * ユーザーぺージの表示
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function myPage($userId)
    {
        $inputs['user_id'] = $userId;
        $questions = $this->question->getQuestion($inputs);
        return view('user.question.mypage', compact('questions'));
    }
}
