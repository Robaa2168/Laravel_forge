<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Matches;

class QuestionsController extends Controller
{
    public function index($id)
    {
        $matches          = Matches::findOrFail($id);
        $pageTitle      = 'Questions for - '.$matches->name;
        $emptyMessage   = 'No question found';
        $questions      = Question::where('matches_id', $matches->id)->with('options')->latest()->paginate(getPaginate());

        return view('admin.question.index',compact('pageTitle', 'matches', 'emptyMessage', 'questions'));
    }

    public function store(Request $request, $id = 0)
    {

        $request->validate([
            'matches_id'  => 'required|exists:matches,id',
            'name'      => 'required',
        ]);

        if($id){
            $question               = Question::findOrFail($id);
            $notification           = 'New question updated successfully';
            $question->result       = 0;
            $question->status       = $request->status ? 1 : 0;
        }else{
            $question               = new Question();
            $question->matches_id     = $request->matches_id;
            $notification           = 'New question added successfully';
        }

        $question->name     = $request->name;
        $question->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }



}
