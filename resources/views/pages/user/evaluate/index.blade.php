@extends('layout.user')
@section('user')
    <div class="container">
        <div class="row px-md-5">
            <div class="col px-md-5">
                {{-- form start --}}
                <form action="#" method="post" id="evaluation_form">
                    @csrf

                    <div class="rounded bg-white p-3 my-3 shadow-sm">
                        <input type="hidden" name="evaluation_id" value="{{ $id }}">
                        <span class="fw-semibold me-2">Faculty Name:</span><label
                            class="text-capitalize fw-bold">{{ $faculties->first_name . ' ' . $faculties->middle_name . ' ' . $faculties->last_name }}</label>
                    </div>

                    {{-- rating scale --}}
                    <fieldset class="p-3 rounded bg-white shadow-sm">
                        <div class="row mb-2">
                            <p style="font-size:18px;">The following statements will be used to evaluate the teaching
                                performance of a faculty while teaching:</p>
                        </div>
                        <div class="d-flex justify-content-center">
                            <table>
                                <tr>
                                    <td>Scale</td>
                                    <th width="60px"></th>
                                    <td>Descriptive Rating</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-star-fill me-2 text-warning"></i>5</td>
                                    <td></td>
                                    <td width="400px">
                                        <div class="progress" role="progressbar">
                                            <div class="progress-bar bg-success" style="width:100%;">Outstanding</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-star-fill me-2 text-warning"></i>4</td>
                                    <td></td>
                                    <td width="600px">
                                        <div class="progress" role="progressbar">
                                            <div class="progress-bar bg-success" style="width:80%;">Very Satisfactory</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-star-fill me-2 text-warning"></i>3</td>
                                    <td></td>
                                    <td width="400px">
                                        <div class="progress" role="progressbar">
                                            <div class="progress-bar bg-success" style="width:60%;">Satisfactory</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-star-fill me-2 text-warning"></i>2</td>
                                    <td></td>
                                    <td width="400px">
                                        <div class="progress" role="progressbar">
                                            <div class="progress-bar bg-success" style="width:40%;">Fairly Satisfactory
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-star-fill me-2 text-warning"></i>1</td>
                                    <td></td>
                                    <td width="400px">
                                        <div class="progress" role="progressbar">
                                            <div class="progress-bar bg-success" style="width:20%;">Needs Improvement</div>
                                        </div>
                                    </td>
                                </tr>


                            </table>
                        </div>
                    </fieldset>

                    {{-- criteria 1 start --}}
                    <div class="card my-3 border border-success" id="main_card">

                        <div class="card-header d-flex justify-content-between py-3 border-bottom border-success"
                            id="card_header">
                            {{-- <button id="toggleCardBody" class="btn btn-success">Toggle Card Body</button> --}}
                            <h3 class="card-title fs-6 fw-semibold m-0 text-success" id="criteria_title">Teachers's
                                Personality (10 %)</h3>
                            <a role="button" id="toggleCardBody">
                                <div id="svg_carret"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-caret-down-fill text-success" viewBox="0 0 16 16">
                                        <path
                                            d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="card-body px-md-5" id="cardBody">
                            <div id="criteria_1">
                                {{-- question 1 --}}
                            </div>
                        </div>
                    </div>
                    {{-- criteria 1 end --}}

                    {{-- criteria 2 start --}}
                    <div class="card my-3 border border-success" id="main_card_2">

                        <div class="card-header d-flex justify-content-between py-3 border-bottom border-success"
                            id="card_header_2">
                            {{-- <button id="toggleCardBody" class="btn btn-success">Toggle Card Body</button> --}}
                            <h3 class="card-title fs-6 fw-semibold m-0 text-success" id="criteria_title_2">Classroom
                                Management (10 %)</h3>
                            <a role="button" id="toggleCardBody_2">
                                <div id="svg_carret_2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-caret-down-fill text-success" viewBox="0 0 16 16">
                                        <path
                                            d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="card-body px-md-5" id="cardBody_2">
                            <div id="criteria_2">
                                {{-- question 2 --}}
                            </div>
                        </div>
                    </div>
                    {{-- criteria 2 end --}}

                    {{-- criteria 3 start --}}
                    <div class="card my-3 border border-success" id="main_card_3">

                        <div class="card-header d-flex justify-content-between py-3 border-bottom border-success"
                            id="card_header_3">
                            {{-- <button id="toggleCardBody" class="btn btn-success">Toggle Card Body</button> --}}
                            <h3 class="card-title fs-6 fw-semibold m-0 text-success" id="criteria_title_3">Knowledge of the
                                Subject Matter (20 %)</h3>
                            <a role="button" id="toggleCardBody_3">
                                <div id="svg_carret_3"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-caret-down-fill text-success" viewBox="0 0 16 16">
                                        <path
                                            d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="card-body px-md-5" id="cardBody_3">
                            <div id="criteria_3">
                                {{-- question 3 --}}
                            </div>
                        </div>
                    </div>
                    {{-- criteria 3 end --}}

                    {{-- criteria 4 start --}}
                    <div class="card my-3 border border-success" id="main_card_4">

                        <div class="card-header d-flex justify-content-between py-3 border-bottom border-success"
                            id="card_header_4">
                            {{-- <button id="toggleCardBody" class="btn btn-success">Toggle Card Body</button> --}}
                            <h3 class="card-title fs-6 fw-semibold m-0 text-success" id="criteria_title_4">Teaching Skills
                                (20 %)</h3>
                            <a role="button" id="toggleCardBody_4">
                                <div id="svg_carret_4"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-caret-down-fill text-success"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="card-body px-md-5" id="cardBody_4">
                            <div id="criteria_4">
                                {{-- question 4 --}}
                            </div>
                        </div>
                    </div>
                    {{-- criteria 4 end --}}

                    {{-- criteria 5 start --}}
                    <div class="card my-3 border border-success" id="main_card_5">

                        <div class="card-header d-flex justify-content-between py-3 border-bottom border-success"
                            id="card_header_5">
                            {{-- <button id="toggleCardBody" class="btn btn-success">Toggle Card Body</button> --}}
                            <h3 class="card-title fs-6 fw-semibold m-0 text-success" id="criteria_title_5">Skills in
                                Evaluating the Students (20 %)</h3>
                            <a role="button" id="toggleCardBody_5">
                                <div id="svg_carret_5"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-caret-down-fill text-success"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="card-body px-md-5" id="cardBody_5">
                            <div id="criteria_5">
                                {{-- question 5 --}}
                            </div>
                        </div>
                    </div>
                    {{-- criteria 5 end --}}

                    {{-- criteria 6 start --}}
                    <div class="card my-3 border border-success" id="main_card_6">

                        <div class="card-header d-flex justify-content-between py-3 border-bottom border-success"
                            id="card_header_6">
                            {{-- <button id="toggleCardBody" class="btn btn-success">Toggle Card Body</button> --}}
                            <h3 class="card-title fs-6 fw-semibold m-0 text-success" id="criteria_title_6">Attitude
                                towards the Subject and the Students (20 %)</h3>
                            <a role="button" id="toggleCardBody_6">
                                <div id="svg_carret_6"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-caret-down-fill text-success"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                    </svg>
                                </div>
                            </a>
                        </div>

                        <div class="card-body px-md-5" id="cardBody_6">
                            <div id="criteria_6">
                                {{-- question 6 --}}
                            </div>
                        </div>
                    </div>
                    {{-- criteria 6 end --}}

                    <div class="row">
                        <div class="col">
                            <textarea class="form-control" placeholder="(Optional) Comments/Suggestions:" id="floatingTextarea2"></textarea> 
                        </div>
                    </div>


                    {{-- button --}}
                    <div class="d-flex justify-content-end py-3">

                        <button type="submit" class="btn btn-secondary btn-md" id="btn_submit_faculties"><i
                                class="bi bi-check-circle me-2"></i>Submit</button>
                    </div>
                    {{-- button --}}

                </form>
                {{-- form end --}}
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @include('pages.user.evaluate.javascript.js')
@endsection
