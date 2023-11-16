<?php

namespace App\Http\Controllers\Admin\Institute;

use App\Models\YearSem;
use App\Models\Question;
use App\Models\Faculties;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Institute extends Controller
{
    public function index()
    {
        return view('pages.admin.institute.index');
    }

    public function select(Request $request)
    {
        // $insitute = $request->insitute;
        $insitute = 'College of Agriculture';


        $faculties = Faculties::where('institute', $insitute)->get();
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;

        $criteria = [
            1 => [
                'pass' => [],
                'failed' => [],
            ],
            2 => [
                'pass' => [],
                'failed' => [],
            ],
            3 => [
                'pass' => [],
                'failed' => [],
            ],
            4 => [
                'pass' => [],
                'failed' => [],
            ],
            5 => [
                'pass' => [],
                'failed' => [],
            ],
            6 => [
                'pass' => [],
                'failed' => [],
            ]
        ];
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

        foreach ($faculties as  $faculty) {
            $evaluates = $faculty->evaluate->where('year_sem', $new_year_sem)->where('status', 1);
            $score = [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
            ];
            $participant = 0;
            foreach ($evaluates as $value) {
                $participant++;
                $evaluation = Evaluation::where('evaluate_id', $value->id)->get();
                foreach ($evaluation as  $evaluation_value) {
                    $answer = $evaluation_value->score;
                    $question = Question::find($evaluation_value->question_id);
                    if ($question->criteria == "Teacher's Personality") {
                        $score[1] += $answer;
                    } else  if ($question->criteria == "Classroom Management") {
                        $score[2] += $answer;
                    } else  if ($question->criteria == "Knowledge of the Subject Matter") {
                        $score[3] += $answer;
                    } else  if ($question->criteria == "Teaching Skills") {
                        $score[4] += $answer;
                    } else  if ($question->criteria == "Skills in Evaluating the Students") {
                        $score[5] += $answer;
                    } else {
                        $score[6] += $answer;
                    }
                }
            }

            foreach ($score as $key => $value) {
                if ($participant != 0) {
                    $formula = (intVal($value) / $hps[0]) * 100 / $participant;
                    $formula = number_format($formula, 1);
                }
                $name = $faculty->last_name . ' ' . $faculty->middle_name . ' ' . $faculty->first_name;
                if ($formula >= 50) {
                    if (!array_key_exists($faculty->id, $criteria[$key]['pass'])) {
                        $criteria[$key]['pass'][$faculty->id] = $name;
                    }
                } else {
                    if (!array_key_exists($faculty->id, $criteria[$key]['failed'])) {
                        $criteria[$key]['failed'][$faculty->id] = $name;
                    }
                }
            }
        }
        $total_faculty = count($faculties);
        foreach ($criteria as $key => $value) {
            $count = count($value['pass']);
            $pass = $count / $total_faculty * 100;

            $count = count($value['failed']);
            $failed = $count / $total_faculty * 100;
            $criteria[$key]['percent'] = [$pass, $failed];
        }

        return response()->json([
            'data' => $criteria,
            'total_faculty' => count($faculties),
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

        function generateAcronym($name)
        {
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
