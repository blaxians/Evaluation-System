<?php

namespace App\Http\Controllers\Admin\Questionnaire;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class Questionnaire extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('get')) {
            $questions = Question::all();
            return view('pages.admin.questionnaire.index', compact('questions'));
        }

        $validated = $request->validate([
            'criteria' => 'required',
            'question' => 'required',
        ]);

        Question::create($validated);
        return back();
    }
}
