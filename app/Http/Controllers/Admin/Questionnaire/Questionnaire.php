<?php

namespace App\Http\Controllers\Admin\Questionnaire;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Questionnaire extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::all();
        return view('pages.admin.questionnaire.index', compact('questions'));
    }

    public function post(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'criteria' => 'required',
            'question' => 'required|unique:questions',
        ]);

        if ($valid->fails()) {
            return response()->json(['errors'=>$valid->messages()]);
        } else {
            $validated = $request->all();
            array_shift($validated);
            Question::create($validated);
            return response()->json(['status'=>'success']);
        }
    }

    public function edit(Request $request, String $id)
    {
        $valid = Validator::make($request->all(), [
            'criteria' => 'required',
            'question' => 'required',
        ]);

        if ($valid->fails()) {
            return response()->json($valid->messages());
        } else {
            try {
                $validated = $request->all();
                array_shift($validated);
                $question = Question::find($id);
                $question->criteria = $validated['criteria'];
                $question->question = $validated['question'];
                $question->update();
                return response()->json('success');
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Question is already exist']);
            }
        }
    }
}
