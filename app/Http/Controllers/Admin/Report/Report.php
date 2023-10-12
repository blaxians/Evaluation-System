<?php

namespace App\Http\Controllers\Admin\Report;

use App\Models\User;
use App\Models\YearSem;
use App\Models\Evaluate;
use App\Models\Question;

use App\Models\Faculties;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class Report extends Controller
{

    public function index()
    {
        return view('pages.admin.report.index');
    }

    public function card()
    {
        $cards = '<div class="row g-3">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="my-3 text-center border-bottom pb-2">
                                    <img src="storage/img/main/basc.png" class="img-thumbnail rounded-circle" width="100">
                                </div>
                                <div class="my-3 text-center">
                                    <h6 class="fw-semibold">College of Agriculture</h6>
                                    <button class="btn btn-success btn-sm" id="btn_ca_show">show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="my-3 text-center border-bottom pb-2">
                                    <img src="storage/img/main/basc.png" class="img-thumbnail rounded-circle" width="100">
                                </div>
                                <div class="my-3 text-center">
                                    <h6 class="fw-semibold">Institute of Arts and Sciences</h6>
                                    <button class="btn btn-success btn-sm" id="btn_ias_view">show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="my-3 text-center border-bottom pb-2">
                                    <img src="storage/img/main/basc.png" class="img-thumbnail rounded-circle" width="100">
                                </div>
                                <div class="my-3 text-center">
                                    <h6 class="fw-semibold">Institute of Engineering and Applied Technology</h6>
                                    <button class="btn btn-success btn-sm" id="btn_ieat_view">show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="my-3 text-center border-bottom pb-2">
                                    <img src="storage/img/main/basc.png" class="img-thumbnail rounded-circle" width="100">
                                </div>
                                <div class="my-3 text-center">
                                    <h6 class="fw-semibold">Institute of Education</h6>
                                    <button class="btn btn-success btn-sm" id="btn_ied_view">show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="my-3 text-center border-bottom pb-2">
                                    <img src="storage/img/main/basc.png" class="img-thumbnail rounded-circle" width="100">
                                </div>
                                <div class="my-3 text-center">
                                    <h6 class="fw-semibold">Institute of Management</h6>
                                    <button class="btn btn-success btn-sm" id="btn_im_view">show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

        return response()->json($cards);
    }

    public function show(Request $request)
    {
        $insti = $request->insti;
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;

        $faculties = Faculties::where('institute', $insti)->get();
        $faculties_table_view = '<div class="row">
                                <div class="col">
                                <div class="py-3">
                                <button class="btn btn-warning btn-sm"
                                id="btn_back_view"><i class="bi bi-caret-left-fill me-2"></i>Back</button></div>
                                <table class="table table-bordered table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee Id</th>
                                        <th>Name</th>
                                        <th>Institute</th>
                                        <th>Report</th>
                                    </tr>
                                </thead>
                                <tbody>';
        foreach ($faculties as $key => $value) {

            $emp_id = $value->employee_id;
            $fullname = $value->first_name . ' ' . $value->middle_name . ' ' . $value->last_name;
            $institute = $value->institute;

            $faculties_table_view .= '<tr>
                                        <td>' . intval($key + 1) . '</td>
                                        <td>' . $emp_id . '</td>
                                        <td>' . $fullname . '</td>
                                        <td>' . $institute . '</td>
                                        <td class="d-flex">
                                            <button class="btn btn-success btn-sm me-2" id="btn_view_student_score" 
                                            data-id="' . $value->id . '">Student</button>
                                            <button class="btn btn-secondary btn-sm" id="btn_view_dean_score" 
                                            data-id="' . $value->id . '">Dean</button>
                                        </td>
                                    </tr>';
        }
        $faculties_table_view .= '</tbody>
        </table></div>
        </div>';



        return response()->json($faculties_table_view);
    }

    // eto link para sa evaluation ng student
    public function viewFromStudent(Request $request)
    {
        $id = $request->id;
        $faculties = Faculties::find($id);
        $evaluates = $faculties->evaluate;

        $score = [];
        foreach ($evaluates as $value) {
            $user = User::find($value->user_id);
            if ($user->role === 'student') {

                $evaluation = Evaluation::where('evaluate_id', $value->id)->get();
                foreach ($evaluation as  $evaluation_value) {

                    $question = Question::find($evaluation_value->question_id);

                    if (array_key_exists($question->criteria, $score)) {
                        $score[$question->criteria] += intVal($evaluation_value->score);
                    } else {
                        $score[$question->criteria] = intVal($evaluation_value->score);
                    }
                }
            }
        }

        $q1 = 0;
        $q2 = 0;
        $q3 = 0;
        $q4 = 0;
        $q5 = 0;
        $q6 = 0;

        $question = Question::all();
        foreach ($question as $value) {
            if ($value->criteria === "Teacher's Personality") {
                $q1++;
            } else if ($value->criteria === "Classroom Management") {
                $q2++;
            } else if ($value->criteria === "Knowledge of the Subject Matter") {
                $q3++;
            } else if ($value->criteria === "Teaching Skills") {
                $q4++;
            } else if ($value->criteria === "Skills in Evaluating the Students") {
                $q5++;
            } else if ($value->criteria === "Attitude towards the Subject and the Students") {
                $q6++;
            }
        }




        $computation = [];
        foreach ($score as $key => $value) {
            if ($key === "Teacher's Personality") {
                $percent = 10;
                $formula = intVal($value) / $q1 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Classroom Management") {
                $percent = 10;
                $formula = intVal($value) / $q2 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Knowledge of the Subject Matter") {
                $percent = 20;
                $formula = intVal($value) / $q3 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Teaching Skills") {
                $percent = 20;
                $formula = intVal($value) / $q4 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Skills in Evaluating the Students") {
                $percent = 20;
                $formula = intVal($value) / $q5 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Attitude towards the Subject and the Students") {
                $percent = 20;
                $formula = intVal($value) / $q6 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            }
        }


        $faculty_name = $faculties->first_name . ' ' . $faculties->middle_name . ' ' . $faculties->last_name;
        $faculties_score = '<table class="table table-borderred table-hover">
                    <thead class="table-success">
                        <tr class="text-center">
                            <th>Areas of Evaluation</th>
                            <th>Total Score</th>
                            <th>Percentage</th>
                            <th>Formula/Equation</th>
                            <th>Equivalent</th>
                        </tr>
                    </thead>
                    <tbody>';

        if (count($computation) > 0) {
            $gen_button_active = '1';
            foreach ($computation as $key => $value) {
                $criteria = $key;
                $total_score = $value[0];
                $percentage = $value[1];
                $equation = $value[2];
                $equivalents = $value[3];

                $faculties_score .= '<tr class="text-center">
                                    <td>' . $criteria . '</td>
                                    <td>' . $total_score . '</td>
                                    <td>' . $percentage . '%</td>
                                    <td>' . $equation . '</td>
                                    <td><span class="badge text-bg-warning">' . $equivalents . '</span></td>
                                </tr>';
            }
        } else {
            $gen_button_active = '0';
            $faculties_score .= '<tr class="text-center">
                                <td colspan="5">No data in database</td>
                            </tr>';
        }

        $faculties_score .= '</tbody>
                        </table>';




        return response()->json(['name' => $faculty_name, 'faculties' => $faculties_score, 'faculties_detail' => $faculties, 'btn_gen' => $gen_button_active]);
    }
    // eto link para sa evaluation ng dean
    public function viewFromDean(Request $request)
    {
        $id = $request->id;
        $faculties = Faculties::find($id);
        $evaluates = $faculties->evaluate;


        $score = [];
        foreach ($evaluates as $value) {
            $user = User::find($value->user_id);
            if ($user->role === 'dean') {

                $evaluation = Evaluation::where('evaluate_id', $value->id)->get();
                foreach ($evaluation as  $evaluation_value) {

                    $question = Question::find($evaluation_value->question_id);

                    if (array_key_exists($question->criteria, $score)) {
                        $score[$question->criteria] += intVal($evaluation_value->score);
                    } else {
                        $score[$question->criteria] = intVal($evaluation_value->score);
                    }
                }
            }
        }


        $q1 = 0;
        $q2 = 0;
        $q3 = 0;
        $q4 = 0;
        $q5 = 0;
        $q6 = 0;

        $question = Question::all();
        foreach ($question as $value) {
            if ($value->criteria === "Teacher's Personality") {
                $q1++;
            } else if ($value->criteria  === "Classroom Management") {
                $q2++;
            } else if ($value->criteria  === "Knowledge of the Subject Matter") {
                $q3++;
            } else if ($value->criteria  === "Teaching Skills") {
                $q4++;
            } else if ($value->criteria  === "Skills in Evaluating the Students") {
                $q5++;
            } else if ($value->criteria  === "Attitude towards the Subject and the Students") {
                $q6++;
            }
        }

        $computation = [];
        foreach ($score as $key => $value) {
            if ($key === "Teacher's Personality") {
                $percent = 10;
                $formula = intVal($value) / $q1 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Classroom Management") {
                $percent = 10;
                $formula = intVal($value) / $q2 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Knowledge of the Subject Matter") {
                $percent = 20;
                $formula = intVal($value) / $q3 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Teaching Skills") {
                $percent = 20;
                $formula = intVal($value) / $q4 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Skills in Evaluating the Students") {
                $percent = 20;
                $formula = intVal($value) / $q5 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Attitude towards the Subject and the Students") {
                $percent = 20;
                $formula = intVal($value) / $q6 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            }
        }
        $faculty_name = $faculties->first_name . ' ' . $faculties->middle_name . ' ' . $faculties->last_name;
        $faculties_score = '<table class="table table-borderred table-hover">
                    <thead class="table-success">
                        <tr class="text-center">
                            <th>Areas of Evaluation</th>
                            <th>Total Score</th>
                            <th>Percentage</th>
                            <th>Formula/Equation</th>
                            <th>Equivalent</th>
                        </tr>
                    </thead>
                    <tbody>';

        if (count($computation) > 0) {
            $gen_button_active = '1';
            foreach ($computation as $key => $value) {
                $criteria = $key;
                $total_score = $value[0];
                $percentage = $value[1];
                $equation = $value[2];
                $equivalents = $value[3];

                $faculties_score .= '<tr class="text-center">
                                    <td>' . $criteria . '</td>
                                    <td>' . $total_score . '</td>
                                    <td>' . $percentage . '%</td>
                                    <td>' . $equation . '</td>
                                    <td><span class="badge text-bg-warning">' . $equivalents . '</span></td>
                                </tr>';
            }
        } else {
            $gen_button_active = '0';
            $faculties_score .= '<tr class="text-center">
                                <td colspan="5">No data in database</td>
                            </tr>';
        }

        $faculties_score .= '</tbody>
                        </table>';


        return response()->json([
            'name' => $faculty_name, 'faculties' => $faculties_score,
            'faculties_detail' => $faculties,
            'btn_gen' => $gen_button_active
        ]);
    }

    public function generatePdfStudent(Request $request)
    {

        $id = $request->id;
        $data = explode(',', $id);
        $faculties = Faculties::find($data[0]);
        $evaluates = $faculties->evaluate;

        $score = [];
        if ($data[1] === 'student') {
            foreach ($evaluates as $value) {
                $user = User::find($value->user_id);
                if ($user->role === 'student') {

                    $evaluation = Evaluation::where('evaluate_id', $value->id)->get();
                    foreach ($evaluation as  $evaluation_value) {

                        $question = Question::find($evaluation_value->question_id);

                        if (array_key_exists($question->criteria, $score)) {
                            $score[$question->criteria] += intVal($evaluation_value->score);
                        } else {
                            $score[$question->criteria] = intVal($evaluation_value->score);
                        }
                    }
                }
            }
        } else {
            foreach ($evaluates as $value) {
                $user = User::find($value->user_id);
                if ($user->role === 'dean') {

                    $evaluation = Evaluation::where('evaluate_id', $value->id)->get();
                    foreach ($evaluation as  $evaluation_value) {

                        $question = Question::find($evaluation_value->question_id);

                        if (array_key_exists($question->criteria, $score)) {
                            $score[$question->criteria] += intVal($evaluation_value->score);
                        } else {
                            $score[$question->criteria] = intVal($evaluation_value->score);
                        }
                    }
                }
            }
        }

        $q1 = 0;
        $q2 = 0;
        $q3 = 0;
        $q4 = 0;
        $q5 = 0;
        $q6 = 0;

        $question = Question::all();
        foreach ($question as $value) {
            if ($value->criteria === "Teacher's Personality") {
                $q1++;
            } else if ($value->criteria === "Classroom Management") {
                $q2++;
            } else if ($value->criteria === "Knowledge of the Subject Matter") {
                $q3++;
            } else if ($value->criteria === "Teaching Skills") {
                $q4++;
            } else if ($value->criteria === "Skills in Evaluating the Students") {
                $q5++;
            } else if ($value->criteria === "Attitude towards the Subject and the Students") {
                $q6++;
            }
        }

        $computation = [];
        foreach ($score as $key => $value) {
            if ($key === "Teacher's Personality") {
                $percent = 10;
                $formula = intVal($value) / $q1 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Classroom Management") {
                $percent = 10;
                $formula = intVal($value) / $q2 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Knowledge of the Subject Matter") {
                $percent = 20;
                $formula = intVal($value) / $q3 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Teaching Skills") {
                $percent = 20;
                $formula = intVal($value) / $q4 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Skills in Evaluating the Students") {
                $percent = 20;
                $formula = intVal($value) / $q5 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Attitude towards the Subject and the Students") {
                $percent = 20;
                $formula = intVal($value) / $q6 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            }
        }

        // Type if student or dean ung ni click na view
        $type = $data[1];
        $pdf = Pdf::loadView('pages.admin.report.pdf', compact('faculties', 'computation', 'type'));
        // download PDF file with download method
        $pdf->setPaper('A4', 'Portrait');
        return $pdf->download('Evaluation_Report_of_' . date('F d, Y') . '.pdf');
    }
}
