<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\User;
use App\Models\YearSem;
use App\Models\Evaluate;
use App\Models\Question;
use App\Models\Faculties;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Dashboard extends Controller
{
    public function index()
    {
        return view('pages.admin.dasboard.index');
    }

    public function show()
    {
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        return response()->json($year_sem);
    }


    // Add School Year
    public function post(Request $request)
    {

        $validatator = Validator::make($request->all(), [
            'year' => 'required|unique:year_sems',
        ]);

        if ($validatator->fails()) {
            return response()->json(['error' => $validatator->messages()]);
        } else {
            $valid = $request->all();

            array_shift($valid);
            $year_sem = new YearSem();
            $year_sem->year = $valid['year'];
            $year_sem->semester = 1;
            $year_sem->save();
            return response()->json('success');
        }
    }


    // Edit the Semester
    public function edit(Request $request)
    {

        $id = $request->id;
        $year_sem = YearSem::find($id);
        if ($year_sem === null) {
            return response()->json(['error' => 'School Year not found']);
        } else {

            $validatator = Validator::make($request->all(), [
                'semester' => 'required',
            ]);

            if ($validatator->fails()) {
                return response()->json(['error' => $validatator->messages()]);
            } else {
                $valid = $request->all();

                if ($year_sem->semester == $valid['semester']) {
                    return response()->json(['error' => 'Semester is already set']);
                } else {

                    if ($year_sem->semester == 2 && $valid['semester'] == 1) {
                        return response()->json(['error' => "Can't go back any further"]);
                    } else {
                        $year_sem->semester = $valid['semester'];
                        $year_sem->update();
                        return response()->json('success');
                    }
                }
            }
        }
    }


    //stats

    public function statistic()
    {
        $user = User::with('evaluate')->where('role', '!=', 'admin')->get();

        $total_faculties = Faculties::count();
        $total_students = User::where('role', 'student')->count();

        $institutes = ['College of Agriculture', 'Institute of Arts and Sciences', 'Institute of Engineering and Applied Technology', 'Institute of Education', 'Institute of Management'];

        $total_per_institute = [];

        foreach ($institutes as $institute) {
            $total_per_institute[] = Faculties::where('institute', $institute)->count();
        }

        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;

        $dean = [0, 0];
        $student = [0, 0];

        foreach ($user as $value) {
            $evaluate = $value->evaluate->where('year_sem', $new_year_sem);
            $true = $evaluate->isNotEmpty() && $evaluate->every(function ($evaluate_value) {
                return $evaluate_value->status != 0;
            });

            if ($value->role == 'student') {
                $student[$true ? 0 : 1]++;
            } else {
                $dean[$true ? 0 : 1]++;
            }
        }
        $number_format_faculty = number_format($total_faculties);
        $number_format_students = number_format($total_students);

        //Top Rated
        $faculties = Faculties::all();
        foreach ($faculties as  $faculty) {
            $year_sem = YearSem::orderBy('id', 'DESC')->first();
            $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;
            $evaluates = $faculty->evaluate->where('year_sem', $new_year_sem)->where('status', 1);
            $score = [];
            $participant = 0;
            foreach ($evaluates as $value) {
                $participant++;
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


            $hps = [0, 0, 0, 0, 0, 0];
            $question = Question::all();
            foreach ($question as $value) {
                if ($value->criteria === "Teacher's Personality") {
                    $hps[0]++;
                } else if ($value->criteria === "Classroom Management") {
                    $hps[1]++;
                } else if ($value->criteria === "Knowledge of the Subject Matter") {
                    $hps[2]++;
                } else if ($value->criteria === "Teaching Skills") {
                    $hps[3]++;
                } else if ($value->criteria === "Skills in Evaluating the Students") {
                    $hps[4]++;
                } else if ($value->criteria === "Attitude towards the Subject and the Students") {
                    $hps[5]++;
                }
            }

            foreach ($hps as $key => $value) {
                $hps[$key] = $value * 5;
            }

            $computation = [];
            foreach ($score as $key => $value) {

                if ($key === "Teacher's Personality") {
                    $percent = 10;
                    $formula = intVal($value) / $hps[0] * $percent / $participant;
                    $formula = number_format($formula, 1);
                    $equivalent = '';
                    if ($formula <= 100 && $formula >= 90) {
                        $equivalent = 'Outstanding';
                    } else if ($formula <= 89 && $formula >= 85) {
                        $equivalent = 'Very Satisfactory';
                    } else if ($formula <= 84 && $formula >= 80) {
                        $equivalent = 'Satisfactory';
                    } else if ($formula <= 79 && $formula >= 75) {
                        $equivalent = 'Fairly Satisfactory';
                    } else {
                        $equivalent = 'Needs Improvement';
                    }
                    $computation[$key] = [$value, $percent, $formula, $equivalent];
                } else if ($key === "Classroom Management") {
                    $percent = 10;
                    $formula = intVal($value) / $hps[1] * $percent / $participant;
                    $formula = number_format($formula, 1);
                    $equivalent = '';
                    if ($formula <= 100 && $formula >= 90) {
                        $equivalent = 'Outstanding';
                    } else if ($formula <= 89 && $formula >= 85) {
                        $equivalent = 'Very Satisfactory';
                    } else if ($formula <= 84 && $formula >= 80) {
                        $equivalent = 'Satisfactory';
                    } else if ($formula <= 79 && $formula >= 75) {
                        $equivalent = 'Fairly Satisfactory';
                    } else {
                        $equivalent = 'Needs Improvement';
                    }
                    $computation[$key] = [$value, $percent, $formula, $equivalent];
                } else if ($key === "Knowledge of the Subject Matter") {
                    $percent = 20;
                    $formula = intVal($value) / $hps[2] * $percent / $participant;
                    $formula = number_format($formula, 1);
                    $equivalent = '';
                    if ($formula <= 100 && $formula >= 90) {
                        $equivalent = 'Outstanding';
                    } else if ($formula <= 89 && $formula >= 85) {
                        $equivalent = 'Very Satisfactory';
                    } else if ($formula <= 84 && $formula >= 80) {
                        $equivalent = 'Satisfactory';
                    } else if ($formula <= 79 && $formula >= 75) {
                        $equivalent = 'Fairly Satisfactory';
                    } else {
                        $equivalent = 'Needs Improvement';
                    }
                    $computation[$key] = [$value, $percent, $formula, $equivalent];
                } else if ($key === "Teaching Skills") {
                    $percent = 20;
                    $formula = intVal($value) / $hps[3] * $percent / $participant;
                    $formula = number_format($formula, 1);
                    $equivalent = '';
                    if ($formula <= 100 && $formula >= 90) {
                        $equivalent = 'Outstanding';
                    } else if ($formula <= 89 && $formula >= 85) {
                        $equivalent = 'Very Satisfactory';
                    } else if ($formula <= 84 && $formula >= 80) {
                        $equivalent = 'Satisfactory';
                    } else if ($formula <= 79 && $formula >= 75) {
                        $equivalent = 'Fairly Satisfactory';
                    } else {
                        $equivalent = 'Needs Improvement';
                    }
                    $computation[$key] = [$value, $percent, $formula, $equivalent];
                } else if ($key === "Skills in Evaluating the Students") {
                    $percent = 20;
                    $formula = intVal($value) / $hps[4] * $percent / $participant;
                    $formula = number_format($formula, 1);
                    $equivalent = '';
                    if ($formula <= 100 && $formula >= 90) {
                        $equivalent = 'Outstanding';
                    } else if ($formula <= 89 && $formula >= 85) {
                        $equivalent = 'Very Satisfactory';
                    } else if ($formula <= 84 && $formula >= 80) {
                        $equivalent = 'Satisfactory';
                    } else if ($formula <= 79 && $formula >= 75) {
                        $equivalent = 'Fairly Satisfactory';
                    } else {
                        $equivalent = 'Needs Improvement';
                    }
                    $computation[$key] = [$value, $percent, $formula, $equivalent];
                } else if ($key === "Attitude towards the Subject and the Students") {
                    $percent = 20;
                    $formula = intVal($value) / $hps[5] * $percent / $participant;
                    $formula = number_format($formula, 1);
                    $equivalent = '';
                    if ($formula <= 100 && $formula >= 90) {
                        $equivalent = 'Outstanding';
                    } else if ($formula <= 89 && $formula >= 85) {
                        $equivalent = 'Very Satisfactory';
                    } else if ($formula <= 84 && $formula >= 80) {
                        $equivalent = 'Satisfactory';
                    } else if ($formula <= 79 && $formula >= 75) {
                        $equivalent = 'Fairly Satisfactory';
                    } else {
                        $equivalent = 'Needs Improvement';
                    }
                    $computation[$key] = [$value, $percent, $formula, $equivalent];
                }
            }

            $average = 0;
            foreach ($computation as $key => $value) {
                $average += $value[2];
            }
            $equivalent = '';
            if ($average <= 100 && $average >= 90) {
                $equivalent = 'Outstanding';
            } else if ($average <= 89 && $average >= 85) {
                $equivalent = 'Very Satisfactory';
            } else if ($average <= 84 && $average >= 80) {
                $equivalent = 'Satisfactory';
            } else if ($average <= 79 && $average >= 75) {
                $equivalent = 'Fairly Satisfactory';
            } else {
                $equivalent = 'Needs Improvement';
            }
            $faculty->average = $average;
            $faculty->equivalent = $equivalent;
        }

        function bubbleSort($array)
        {
            $n = count($array);
            if ($n === 0 || $n === 1) {
                return $array;
            }
            for ($i = 0; $i < $n - 1; $i++) {
                for ($j = 0; $j < $n - $i - 1; $j++) {
                    if ($array[$j]->average > $array[$j + 1]->average) {
                        $temp = $array[$j];
                        $array[$j] = $array[$j + 1];
                        $array[$j + 1] = $temp;
                    }
                }
            }
            return $array;
        }
        $sorted_array = bubbleSort($faculties);
        $array = [];
        foreach ($sorted_array as $key => $value) {

            array_push(
                $array,
                [
                    'id' => $value->id,
                    'name' => $value->last_name . ', ' . $value->first_name . ' ' . $value->middle_name,
                    'institute' => $value->institute,
                    'average' => $value->average,
                    'equivalent' => $value->equivalent
                ]
            );
        }

        $top = array_slice($array, -10);
        $top_10 = array_reverse($top);

        return response()->json([
            'total_faculty' => $number_format_faculty,
            'total_student' => $number_format_students,
            'total_institute' => $total_per_institute,
            'dean' => $dean,
            'student' => $student,
            'top_10' => $top_10,
        ]);
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;
        $faculties = Faculties::find($id);
        $evaluates = $faculties->evaluate->where('year_sem', $new_year_sem)->where('status', 1);

        $score = [];
        $student = 0;
        foreach ($evaluates as $value) {
            $student++;
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

        $hps = [0, 0, 0, 0, 0, 0];
        $question = Question::all();
        foreach ($question as $value) {
            if ($value->criteria === "Teacher's Personality") {
                $hps[0]++;
            } else if ($value->criteria === "Classroom Management") {
                $hps[1]++;
            } else if ($value->criteria === "Knowledge of the Subject Matter") {
                $hps[2]++;
            } else if ($value->criteria === "Teaching Skills") {
                $hps[3]++;
            } else if ($value->criteria === "Skills in Evaluating the Students") {
                $hps[4]++;
            } else if ($value->criteria === "Attitude towards the Subject and the Students") {
                $hps[5]++;
            }
        }

        foreach ($hps as $key => $value) {
            $hps[$key] = $value * 5;
        }

        $computation = [];
        foreach ($score as $key => $value) {
            if ($key === "Teacher's Personality") {
                $percent = 10;
                $formula = intVal($value) / $hps[0] * $percent / $student;
                $formula = number_format($formula, 1);
                $equivalent = '';
                if ($formula <= 100 && $formula >= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula <= 89 && $formula >= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula <= 84 && $formula >= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula <= 79 && $formula >= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Classroom Management") {
                $percent = 10;
                $formula = intVal($value) / $hps[1] * $percent / $student;
                $formula = number_format($formula, 1);
                $equivalent = '';
                if ($formula <= 100 && $formula >= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula <= 89 && $formula >= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula <= 84 && $formula >= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula <= 79 && $formula >= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Knowledge of the Subject Matter") {
                $percent = 20;
                $formula = intVal($value) / $hps[2] * $percent / $student;
                $formula = number_format($formula, 1);
                $equivalent = '';
                if ($formula <= 100 && $formula >= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula <= 89 && $formula >= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula <= 84 && $formula >= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula <= 79 && $formula >= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Teaching Skills") {
                $percent = 20;
                $formula = intVal($value) / $hps[3] * $percent / $student;
                $formula = number_format($formula, 1);
                $equivalent = '';
                if ($formula <= 100 && $formula >= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula <= 89 && $formula >= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula <= 84 && $formula >= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula <= 79 && $formula >= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Skills in Evaluating the Students") {
                $percent = 20;
                $formula = intVal($value) / $hps[4] * $percent / $student;
                $formula = number_format($formula, 1);
                $equivalent = '';
                if ($formula <= 100 && $formula >= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula <= 89 && $formula >= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula <= 84 && $formula >= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula <= 79 && $formula >= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Attitude towards the Subject and the Students") {
                $percent = 20;
                $formula = intVal($value) / $hps[5] * $percent / $student;
                $formula = number_format($formula, 1);
                $equivalent = '';
                if ($formula <= 100 && $formula >= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula <= 89 && $formula >= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula <= 84 && $formula >= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula <= 79 && $formula >= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            }
        }

        $average = 0;
        foreach ($computation as $key => $value) {
            $average += $value[2];
        }


        $equivalent = '';
        if ($average <= 100 && $average >= 90) {
            $equivalent = 'Outstanding';
        } else if ($average <= 89 && $average >= 85) {
            $equivalent = 'Very Satisfactory';
        } else if ($average <= 84 && $average >= 80) {
            $equivalent = 'Satisfactory';
        } else if ($average <= 79 && $average >= 75) {
            $equivalent = 'Fairly Satisfactory';
        } else {
            $equivalent = 'Needs Improvement';
        }

        function generateAcronym($name) {
            $words = explode(' ', $name);
            $acronym = '';
        
            foreach ($words as $word) {
                if (!empty($word)) {
                    $acronym .= strtoupper(substr($word, 0, 1));
                }
            }
        
            return $acronym;
        }

        // eto ung total and ung equivalent
        $final_average = ['total' => $average, 'equivalent' => $equivalent];


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
                                    <td><span class="badge text-bg-warning">' . generateAcronym($equivalents) . '</span></td>
                                    
                                </tr>';
            }
            $faculties_score .= '<tr class="text-center fw-bold">
                                <td>Total Average</td>
                                <td></td>
                                <td></td>
                                <td>' . $final_average['total'] . '%</td>
                                <td><span class="badge text-bg-secondary">' . generateAcronym($final_average['equivalent']) . '</span></td>
                                </tr>';
        } else {
            $gen_button_active = '0';
            $faculties_score .= '<tr class="text-center">
                                <td colspan="5">No data in database</td>
                            </tr>';
        }
        $faculties_score .= '</tbody>
                        </table>';
        return response()->json([
            'name' => $faculty_name, 'faculties' => $faculties_score, 'faculties_detail' => $faculties, 'btn_gen' => $gen_button_active,
            'final_average' => $final_average['total']
        ]);
    }
}
