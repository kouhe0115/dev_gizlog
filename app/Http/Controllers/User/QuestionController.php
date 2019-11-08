<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CommentRequest;
use App\Http\Requests\User\QuestionsRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Question;
use App\Models\TagCategory;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    private $question;
    private $category;
    private $comment;
    
    public function __construct(Question $question, TagCategory $category, Comment $comment)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->category = $category;
        $this->comment = $comment;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputs = $request->all();
        $questions = $this->question->getQuestion($inputs);
        $categories = $this->category->get();
        
        return view('user.question.index',
               compact('questions', 'categories', 'inputs'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->get()->pluck('name', 'id');
        
        return view('user.question.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $this->question->create($inputs);

        return redirect()->route('question.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->question->find($id);
        return view('user.question.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->question->find($id);
        $categories = $this->category->get()->pluck('name', 'id');
        return view('user.question.edit', compact('question', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionsRequest $request, $id)
    {
        $inputs = $request->all();
        $this->question->find($id)->update($inputs);

        return redirect()->route('question.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->question->find($id)->delete();
    
        return redirect()->route('question.index');
    }
    
    public function confirm(QuestionsRequest $request)
    {
        $inputs = $request->all();
        $categoryName = $this->category->find($inputs['tag_category_id'])->name;
        
        return view('user.question.confirm', compact('inputs', 'categoryName'));
    }
    
    public function commentStore(CommentRequest $request)
    {
        $inputs = $request->all();
        $this->comment->create($inputs);

        return redirect()->route('question.index');
    }
    
    public function myPage($id)
    {
        $inputs['user_id'] = Auth::id();
        $questions = $this->question->getQuestion($inputs);
        
        return view('user.question.mypage', compact('questions'));
    }
}
