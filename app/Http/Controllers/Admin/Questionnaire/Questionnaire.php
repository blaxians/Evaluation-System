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
        return view('pages.admin.questionnaire.index');
    }

    // Show all Question
    public function show()
    {
        $questions = Question::all();
        $table = '';
        if($questions->count()>'0'){
           $table .= '<table class="table bg-white rounded shadow-sm  table-hover" id="table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Question</th>
                                <th scope="col">Criteria</th>
                                <th scope="col" style="text-align:center;">Edit / Delete</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach ($questions as $key => $question){
                                $table .= '<tr>
                                            <td>'.intval($key+1).'</td>
                                            <td>'.$question->question.'</td>
                                            <td>'.$question->criteria.'</td>
                                            <td style="text-align:center;">
                                                <button class="btn btn-sm btn-secondary me-1" id="questionnaire_btn_edit" data-id="'.$question->id.'">
                                                <i class="bi bi-pencil-square"></i></button>
                                                <button class="btn btn-sm btn-danger" id="question_btn_delete" data-id="'.$question->id.'">
                                                <i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>';
                            }
                                
            $table .= '</tbody></table>';
            echo $table;
        } else {
            echo '<div class="h1 text-center text-secondary my-5">There is no record in database.</div>';
            
        }
        
        
    }


    public function post(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'criteria' => 'required',
            'question' => 'required|unique:questions',
        ]);

        if ($valid->fails()) {
            return response()->json(['errors' => $valid->messages()]);
        } else {
            $validated = $request->all();
            array_shift($validated);
            Question::create($validated);
            return response()->json(['status' => 'success']);
        }
    }

    public function view(Request $request)
    {   $id = $request->id;
        $question = Question::find($id);

        if ($question === null) {
            return response()->json(['error' => 'Question not found']);
        } else {
            return response()->json($question);
        }
    }
    public function edit(Request $request)
    {  
        $id = $request->id;
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

    public function delete(Request $request)
    {
        $id = $request->id;
        $question = Question::find($id);
        if ($question === null) {
            return response()->json(['error' => 'Question not found']);
        } else {
            Question::destroy($id);
            return response()->json('success');
        }
    }
}
