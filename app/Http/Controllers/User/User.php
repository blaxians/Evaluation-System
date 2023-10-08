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

    //show yung faculty namay checkbox
    public function show()
    {
        $faculties = Faculties::all();
        $table = '';
        if($faculties->count() > 0){
            $table .= '<table class="table table-hover" id="table">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Institute</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>';
            foreach($faculties as $key => $faculty){
                $table .= '<tr>
                            <td>'.intval($key+1).'</td>
                            <td>'.$faculty->first_name.' '.$faculty->last_name.'</td>
                            <td>'.$faculty->institute.'</td>
                            <td style="text-align:center;"><input type="checkbox" data-id="'.$faculty->id.'" id="faculty_checkbox"></td>
                        </tr>';
            }
                
            $table .= '</tbody>
        </table>';
        echo $table;
             
        }

    }

    // view yung mga na select na faculty ni user sa table
    public function view()
        {
            $user = auth()->user();
            $year_sem = YearSem::orderBy('id', 'DESC')->first();
            $new_year_sem = $year_sem->year . " " . $year_sem->semester;

            $evaluate_proffessor  = Evaluate::where('user_id', $user->id)->where('year_sem', $new_year_sem)->get();
            $htmlCard = '';
            $status_array = [];
            foreach ($evaluate_proffessor as $key => $value) {

                $id = $value->id;
                $faculties = Faculties::find($value->faculties_id);
                $name = $faculties->last_name . ' ' . $faculties->middle_name . ' ' . $faculties->first_name;
                $status = $value->status;
                $institute = $faculties->institute;
                $status_array[] = $status;

                //responsive design sa badge at button depende sa status
                $statusBadgeClass = $status == 0 ? 'text-bg-secondary' : 'text-bg-success';
                $statusBadgeName = $status == 0 ? 'To Evaluate' : 'Evaluated';
                $btn_disable = $status == 1 ? '<button type="button" class="btn btn-success  btn-sm" disabled><i class="bi bi-dash-circle"></i></button>' : '
                <button class="btn btn-success btn-sm" id="btn_evaluate" data-id="'.$id.'"><i class="bi bi-pencil-square me-1"></i>Evaluate</button>';

                $htmlCard .= '<div class="col-md-3 p-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $name . '</h5>
                                        <p class="card-text">'.$institute.'</p>
                                        <span class="badge '.$statusBadgeClass.'">'.$statusBadgeName.'</span> 
                                    </div>
                                    <div class="card-footer d-flex  justify-content-end"> 
                                        '.$btn_disable.'
                                    </div>
                                </div>
                            </div>';
            }
            $result = array_reduce($status_array, function($carry, $stats) {
                return $carry && ($stats == 1);
            }, true);
            
            $alert_message = '<div class="alert alert-success d-flex align-items-center mt-3" role="alert">
                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                <div class="fw-semibold">
                  You have successfully evaluated all faculties on your list!
                </div>
              </div>';

            if($result){
                return response()->json(['status'=>'success', 'card'=>$htmlCard, 'alert'=>$alert_message]);
            } else {
                return response()->json(['card'=>$htmlCard]);
            }
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

        if (count($faculties) == 0) {
            return response()->json(['error' => 'No data of Faculties']);
        } else {
            foreach ($faculties as  $value) {
                $evaluation = new Evaluate();
                $evaluation->user_id = $user->id;
                $evaluation->faculties_id = $value->id;
                $evaluation->year_sem = $new_year_sem;
                $evaluation->status = 0;
                $evaluation->save();
            }

            return redirect()->route('index.student');
        }
    }

    // Route the page to evaluate
    public function viewEvaluate(String $id)
    {
        return view('pages.user.evaluate.index',compact('id'));
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
                            <div class="card-title fs-6">'.$question->question.'</div>
                        </div>
                        <div class="card-body d-flex justify-content-evenly">
                        
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question->id.'" id="radio_5" value="5" required>
                                <label class="form-check-label" for="radio_5">5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question->id.'" id="radio_4" value="4" required>
                                <label class="form-check-label" for="radio_4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question->id.'" id="radio_3" value="3" required>
                                <label class="form-check-label" for="radio_3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question->id.'" id="radio_2" value="2" required>
                                <label class="form-check-label" for="radio_2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question->id.'" id="radio_1" value="1" required>
                                <label class="form-check-label" for="radio_1">1</label>
                            </div>
                        </div>
                    </div>';
        }
    

        foreach ($array_2 as $key => $question2){
            $criteria_2 .= '<div class="card my-3">
                        <div class="card-header bg-white">
                            <div class="card-title fs-6">'.$question2->question.'</div>
                        </div>
                        <div class="card-body d-flex justify-content-evenly">
                        
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question2->id.'" id="radio_5" value="5" required>
                                <label class="form-check-label" for="radio_5">5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question2->id.'" id="radio_4" value="4" required>
                                <label class="form-check-label" for="radio_4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question2->id.'" id="radio_3" value="3" required>
                                <label class="form-check-label" for="radio_3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question2->id.'" id="radio_2" value="2" required>
                                <label class="form-check-label" for="radio_2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question2->id.'" id="radio_1" value="1" required>
                                <label class="form-check-label" for="radio_1">1</label>
                            </div>
                        </div>
                    </div>';
        }

        foreach ($array_3 as $key => $question3){
            $criteria_3 .= '<div class="card my-3">
                        <div class="card-header bg-white">
                            <div class="card-title fs-6">'.$question3->question.'</div>
                        </div>
                        <div class="card-body d-flex justify-content-evenly">
                        
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question3->id.'" id="radio_5" value="5" required>
                                <label class="form-check-label" for="radio_5">5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question3->id.'" id="radio_4" value="4" required>
                                <label class="form-check-label" for="radio_4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question3->id.'" id="radio_3" value="3" required>
                                <label class="form-check-label" for="radio_3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question3->id.'" id="radio_2" value="2" required>
                                <label class="form-check-label" for="radio_2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question3->id.'" id="radio_1" value="1" required>
                                <label class="form-check-label" for="radio_1">1</label>
                            </div>
                        </div>
                    </div>';
        }

        foreach ($array_4 as $key => $question4){
            $criteria_4 .= '<div class="card my-3">
                        <div class="card-header bg-white">
                            <div class="card-title fs-6">'.$question4->question.'</div>
                        </div>
                        <div class="card-body d-flex justify-content-evenly">
                        
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question4->id.'" id="radio_5" value="5" required>
                                <label class="form-check-label" for="radio_5">5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question4->id.'" id="radio_4" value="4" required>
                                <label class="form-check-label" for="radio_4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question4->id.'" id="radio_3" value="3" required>
                                <label class="form-check-label" for="radio_3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question4->id.'" id="radio_2" value="2" required>
                                <label class="form-check-label" for="radio_2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question4->id.'" id="radio_1" value="1" required>
                                <label class="form-check-label" for="radio_1">1</label>
                            </div>
                        </div>
                    </div>';
        }

        foreach ($array_5 as $key => $question5){
            $criteria_5 .= '<div class="card my-3">
                        <div class="card-header bg-white">
                            <div class="card-title fs-6">'.$question5->question.'</div>
                        </div>
                        <div class="card-body d-flex justify-content-evenly">
                        
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question5->id.'" id="radio_5" value="5" required>
                                <label class="form-check-label" for="radio_5">5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question5->id.'" id="radio_4" value="4" required>
                                <label class="form-check-label" for="radio_4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question5->id.'" id="radio_3" value="3" required>
                                <label class="form-check-label" for="radio_3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question5->id.'" id="radio_2" value="2" required>
                                <label class="form-check-label" for="radio_2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question5->id.'" id="radio_1" value="1" required>
                                <label class="form-check-label" for="radio_1">1</label>
                            </div>
                        </div>
                    </div>';
        }

        foreach ($array_6 as $key => $question6){
            $criteria_6 .= '<div class="card my-3">
                        <div class="card-header bg-white">
                            <div class="card-title fs-6">'.$question6->question.'</div>
                        </div>
                        <div class="card-body d-flex justify-content-evenly">
                        
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question6->id.'" id="radio_5" value="5" required>
                                <label class="form-check-label" for="radio_5">5</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question6->id.'" id="radio_4" value="4" required>
                                <label class="form-check-label" for="radio_4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question6->id.'" id="radio_3" value="3" required>
                                <label class="form-check-label" for="radio_3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question6->id.'" id="radio_2" value="2" required>
                                <label class="form-check-label" for="radio_2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="'.$question6->id.'" id="radio_1" value="1" required>
                                <label class="form-check-label" for="radio_1">1</label>
                            </div>
                        </div>
                    </div>';
        }
        
        return response()->json([
            'criteria_1'=>$criteria_1,
            'criteria_2'=>$criteria_2,
            'criteria_3'=>$criteria_3,
            'criteria_4'=>$criteria_4,
            'criteria_5'=>$criteria_5,
            'criteria_6'=>$criteria_6,

        ]);

        
    }

    //kukunin ang sagot, tas pasok sa database
    public function evaluations(Request $request)
    {
       
        
        $id = $request->id;
        $user = auth()->user();
      
        $id = $request->input('evaluation_id');
        $valid =  $request->except('_token');

        
      
           
            foreach ($valid as $key => $value) {
                if($key!='evaluation_id')
                {
                $evaluation = new Evaluation();
                $evaluation->evaluate_id = $id;
                $evaluation->question_id = $key;
                $evaluation->score = $value;
                $evaluation->save();

                }

            }

            // update the evaluate status
            $evaluate = Evaluate::find($id);
            $evaluate->status = 1;
            $evaluate->update();

            // return redirect()->route('index.student');
            return response()->json('success');
    }

}
