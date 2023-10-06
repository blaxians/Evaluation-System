@extends('layout.user')
@section('user')
    <div class="container-fluid px-4">

        <!-- title of the page start -->
        <div class="row p-0 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col-md d-none d-sm-inline pt-3">
                <h3 class="m-0 fw-bold primary-text fs-4">Welcome</h3>
            </div>
            <div class="col-md align-items-center">
                <div class="row p-2 d-flex flex-nowrap">
                    <div class="col-md d-flex flex-shrink-1 align-items-center p-0 me-2">
                        <i
                            class="fas ms-2 ms-sm-auto fa-calendar fs-4 primary-text p-2 rounded-1 second-text secondary-bg"></i>
                    </div>
                    <div class="col-md p-0">
                        <div class="m-0 fs-6 fw-semibold primary-text" id="#academic_year">Academic Year</div>
                        <div class="m-0 fs-6 primary-text text-nowrap" id="semester">{{ $new_year_sem }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- title of the page end -->

        <div class="row mt-3">
            <div class="col-md">
                <div class="card rounded">
                    <div class="card-header bg-white d-flex">
                        <h3 class="card-title text-success m-0 p-2">Evaluate Professor</h3>
                    </div>
                    <div class="card-body" id="evaluate_professor_table">
                        <h1 class="text-center text-secondary my-5">Loading...</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('javascript')
    @include('pages.user.javascript.js')
@endsection



