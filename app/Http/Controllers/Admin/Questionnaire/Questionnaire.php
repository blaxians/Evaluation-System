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
        return response()->json($questions);
    }

    public function post(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'criteria' => 'required',
            'question' => 'required|unique:questions',
        ]);

        if ($valid->fails()) {
            return response()->json($valid->messages());
        } else {
            $validated = $request->all();
            array_shift($validated);
            Question::create($validated);
            return response()->json('success');
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

    public function delete(String $id)
    {
        $question = Question::find($id);
        if ($question === null) {
            return response()->json(['error' => 'Question not found']);
        } else {
            Question::destroy($id);
            return response()->json('success');
        }
    }
}
