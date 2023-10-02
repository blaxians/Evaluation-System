<?php

namespace App\Http\Controllers\User;

use App\Models\Evaluation;
use App\Models\YearSem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Evaluate;
use App\Models\Faculties;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;

class User extends Controller
{

    public function index()
    {
        return view('pages.user.index');
    }

    // Show the blade of faculties to select by student
    public function select()
    {
        // lalagay name ng design para sa pag pipilian
        return view('pages.user.select_faculty.index');
    }

    public function show()
    {
        $faculties = Faculties::all();
        $table = '';
        if($faculties->count()>0){
            $table .= '<table class="table table-hover" id="table">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Checkbox</th>
                </tr>
            </thead>
            <tbody>';
            foreach($faculties as $key => $faculty){
                $table .= '<tr>
                            <td>'.intval($key+1).'</td>
                            <td>'.$faculty->first_name.' '.$faculty->last_name.'</td>
                            <td><input type="checkbox"></td>
                        </tr>';
            }
                
            $table .= '</tbody>
        </table>';
        echo $table;
             
        }

    }

    // Get all the selected faculties
    public function view()
    {
        $user = auth()->user();
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . " " . $year_sem->semester;

        $evaluation  = Evaluate::where('user', $user->id)->where('year_sem', $new_year_sem)->get();
        return response()->json($evaluation);
    }

    // Select Faculties for Student
    public function post(Request $request)
    {
        $user = auth()->user();
        $valid = $request->all();
        array_shift($valid);
        array_shift($valid);
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . " " . $year_sem->semester;

        $evaluation = new Evaluate();
        foreach ($valid['checkbox'] as $value) {
            $evaluation->user_id = $user->id;
            $evaluation->faculties_id = $value;
            $evaluation->year_sem = $new_year_sem;
            $evaluation->save();
        }

        return redirect()->route('index.student');
    }


    // Dean Automatic
    public function post2()
    {
        $user = auth()->user();
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . " " . $year_sem->semester;
        $faculties = Faculties::where('institute', $user->institute)->get();

        if (count($faculties) === 0) {
            return response()->json(['error' => 'No data of Faculties']);
        } else {

            $evaluation = new Evaluate();
            foreach ($faculties as  $value) {
                $evaluation->user_id = $user->id;
                $evaluation->faculties_id = $value->id;
                $evaluation->year_sem = $new_year_sem;
                $evaluation->save();
            }

            return redirect()->route('index.student');
        }
    }

    // Route the page to evaluate
    public function viewEvaluate($id)
    {
        return view()->with($id);
    }

    public function questions()
    {
        $question = Question::all();
        return  response()->json($question);
    }

    public function evaluations(Request $request, String $id)
    {
        $user = auth()->user();
        $valid = $request->all();
        array_shift($valid);
        array_shift($valid);
        array_shift($valid);

        $question = Question::all();
        // Count the question
        if (count($question) !== count($valid)) {
            return response()->json(['error' => 'All items are required']);
        } else {
            $evaluation = new Evaluation();
            foreach ($valid as $key => $value) {
                $data = explode('-', $key);
                $evaluation->evaluate_id = $id;
                $evaluation->question_id = $data[1];
                $evaluation->score = $value;
                $evaluation->save();
            }

            // update the evaluate status
            $evaluate = Evaluate::find($id);
            $evaluate->status = 1;
            $evaluate->update();

            return redirect()->route('index.student');
        }
    }
}
