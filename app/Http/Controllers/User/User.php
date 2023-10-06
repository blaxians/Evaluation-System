<?php

namespace App\Http\Controllers\User;

use App\Models\YearSem;
use App\Models\Evaluate;
use App\Models\Question;
use App\Models\Faculties;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class User extends Controller
{

    public function index()
    {
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $sem = 'st Semester';
        if($year_sem->semester==2){
            $sem = 'nd Semester';
        }
        $new_year_sem = $year_sem->year . " " . $year_sem->semester.$sem;

        return view('pages.user.index', compact('new_year_sem'));

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
                            <td><input type="checkbox" data-id="'.$faculty->id.'" id="faculty_checkbox"></td>
                        </tr>';
            }
                
            $table .= '</tbody>
        </table>';
        echo $table;
             
        }

    }

    // Get all the selected faculties tas labas dito sa table
    public function view()
        {
            $user = auth()->user();
            $year_sem = YearSem::orderBy('id', 'DESC')->first();
            $new_year_sem = $year_sem->year . " " . $year_sem->semester;

            $evaluate_proffessor  = Evaluate::where('user_id', $user->id)->where('year_sem', $new_year_sem)->get();

            $htmlTable = '<table class="table table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Institute</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

            foreach ($evaluate_proffessor as $key => $value) {
                $faculties = Faculties::find($value->faculties_id);
                $name = $faculties->last_name . ' ' . $faculties->middle_name . ' ' . $faculties->first_name;
                $status = $value->status;
                $institute = $faculties->institute;

                $statusBadgeClass = $status == 0 ? 'text-bg-danger' : 'text-bg-success';
                $statusBadgeName = $status == 0 ? 'To Evaluate' : 'Evaluated';

                $htmlTable .= '<tr>
                                <td>' . $name . '</td>
                                <td>' . $institute . '</td>
                                <td><span class="badge rounded-pill ' . $statusBadgeClass . '">' . $statusBadgeName . '</span></td>
                                <td><button class="btn btn-success btn-sm"><i class="bi bi-pencil-square"></i></button></td>
                            </tr>';
            }

            $htmlTable .= '</tbody></table>';

            echo $htmlTable;
        }

    



    // Select Faculties for Student pasok sa database yung mga na select na faculty
    public function post(Request $request)
    {   
        $user = auth()->user();
        $valid = $request->all();
        
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . " " . $year_sem->semester;
       
        foreach ($valid['id'] as $value) {
            $evaluation = new Evaluate();
            $evaluation->user_id = $user->id;
            $evaluation->faculties_id = $value;
            $evaluation->year_sem = $new_year_sem;
            $evaluation->status = 0;
            $evaluation->save();
        }

        return response()->json('success');
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
    public function viewEvaluate()
    {
        return view('pages.user.evaluate.index');
    }

    //palabasin lahat ng question
    public function questions()
    {
        $criteria_1 = '';
        $criteria_2 = '';
        $criteria_3 = '';
        $criteria_4 = '';
        $criteria_5 = '';
        $criteria_6 = '';
        

        $question = Question::all();
        $array_1 = [];
        $array_2 = [];
        $array_3 = [];
        $array_4 = [];
        $array_5 = [];
        $array_6 = [];
        foreach ($question as $value) {
            if($value->criteria == "Teacher's Personality")
            {
                array_push($array_1, $value);
            }
            else if($value->criteria == "Classroom Management")
            {
                array_push($array_2, $value);
            } 
            else if($value->criteria == "Knowledge of the Subject Matter")
            {
                array_push($array_3, $value);
            } 
            else if($value->criteria == "Teaching Skills")
            {
                array_push($array_4, $value);
            } 
            else if($value->criteria == "Skills in Evaluating the Students")
            {
                array_push($array_5, $value);
            } 
            else if($value->criteria == "Attitude towards the Subject and the Students")
            {
                array_push($array_6, $value);
            } 
        }

        foreach ($array_1 as $key => $question){
            $criteria_1 .= '<div class="card my-3">
                        <div class="card-header bg-white">
                        <input type="hidden" name="id" value="'.$question->id.'">
                            <div class="card-title fs-6">'.$question->question.'</div>
                        </div>
                        <div class="card-body d-flex justify-content-evenly">
                        
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+1).'" id="radio_5" value="5" required>
                                <label class="form-check-label" for="radio_5">5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+1).'" id="radio_4" value="4" required>
                                <label class="form-check-label" for="radio_4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+1).'" id="radio_3" value="3" required>
                                <label class="form-check-label" for="radio_3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+1).'" id="radio_2" value="2" required>
                                <label class="form-check-label" for="radio_2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+1).'" id="radio_1" value="1" required>
                                <label class="form-check-label" for="radio_1">1</label>
                            </div>
                        </div>
                    </div>';
        }
    

        foreach ($array_2 as $key => $question2){
            $criteria_2 .= '<div class="card my-3">
                        <div class="card-header bg-white">
                        <input type="hidden" name="id" value="'.$question2->id.'">
                            <div class="card-title fs-6">'.$question2->question.'</div>
                        </div>
                        <div class="card-body d-flex justify-content-evenly">
                        
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+10).'" id="radio_5" value="5" required>
                                <label class="form-check-label" for="radio_5">5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+10).'" id="radio_4" value="4" required>
                                <label class="form-check-label" for="radio_4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+10).'" id="radio_3" value="3" required>
                                <label class="form-check-label" for="radio_3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+10).'" id="radio_2" value="2" required>
                                <label class="form-check-label" for="radio_2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radio_'.intval($key+10).'" id="radio_1" value="1" required>
                                <label class="form-check-label" for="radio_1">1</label>
                            </div>
                        </div>
                    </div>';
        }
        
        return response()->json(['criteria_1'=>$criteria_1, 'criteria_2'=>$criteria_2]);

        
    }

    //kukunin ang sagot, tas pasok sa database
    public function evaluations(Request $request, String $id)
    {
        $user = auth()->user();
        $valid = $request->all();

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
