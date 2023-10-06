@extends('layout.user')
@section('user')
    <div class="container">
      <div class="row px-md-5">
        <div class="col px-md-5">
          {{-- form start --}}
          <form action="#" method="post" id="evaluation_form">
            <div class="alert alert-success my-3 px-3" role="alert">
              The following statements will be used to evaluate the teaching performance of a faculty while teaching:
            </div>

          {{-- criteria 1 start --}}
              <div class="card my-3 border border-primary" id="main_card">

                    <div class="card-header d-flex justify-content-between py-3 border-bottom border-primary" id="card_header">
                        {{-- <button id="toggleCardBody" class="btn btn-success">Toggle Card Body</button> --}}
                        <h3 class="card-title fs-6 fw-semibold m-0 text-primary" id="criteria_title">Teachers's Personality (10 %)</h3>
                        <a role="button" id="toggleCardBody">
                          <div id="svg_carret"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill text-primary" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
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
              <div class="card my-3 border border-primary" id="main_card_2">

                    <div class="card-header d-flex justify-content-between py-3 border-bottom border-primary" id="card_header_2">
                        {{-- <button id="toggleCardBody" class="btn btn-success">Toggle Card Body</button> --}}
                        <h3 class="card-title fs-6 fw-semibold m-0 text-primary" id="criteria_title_2">Classroom Management (10 %)</h3>
                        <a role="button" id="toggleCardBody_2">
                          <div id="svg_carret_2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill text-primary" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
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
          {{-- criteria 1 end --}}
            <button type="submit" class="btn btn-primary btn-md">Submit</button>
          </form>
          {{-- form end --}}
        </div>
      </div>
    </div>
@endsection
@section('javascript')
    @include('pages.user.evaluate.javascript.js')
@endsection