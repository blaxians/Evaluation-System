@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4">

        <!-- title of the page start -->
        <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col py-2">
                <h3 class="m-0 fw-bold primary-text fs-4">Sorting</h3>
            </div>
        </div>
        <!-- title of the page end -->

        <div class="row mt-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        {{-- title --}}
                        <div class="mb-4">
                            <h3 class="card-title fw-bold text-primary">Campuses</h3>
                        </div>

                        {{-- campus selection --}}
                        <div id="sorting_campuses">
                            <ul class="nav nav-tabs fw-semibold">
                                <li class="nav-item">
                                  <a class="nav-link text-capitalize" role="button" id="campus_select_main"></a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link text-capitalize" role="button" id="campus_select_btvc"></a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link text-capitalize" role="button" id="campus_select_drt"></a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link text-capitalize" role="button" id="campus_select_ffhnas"></a>
                                </li>
                            </ul>
                        </div>
                        {{-- campus selection --}}

                        {{-- student sorting title --}}
                        <div class="my-4">
                            <h5 class="card-title text-secondary">Filter Student</h4>
                        </div>
                        {{-- student sorting title --}}

                        {{-- student sorting --}}
                        <div class="row g-2 d-flex" id="sorting_filter_student">
                            <div class="col">
                                <select class="form-select form-select-sm text-primary fw-semibold" id="institute_select"
                                data-id="institute">
                                    <option class="d-none" id="option_reset_institute" selected value="">&#xF876; Institute</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select form-select-sm d text-primary fw-semibold" id="course_select"
                                data-id="course">
                                    <option class="d-none option_reset" id="option_reset_course" selected value="">&#xF6FD; Course</option>
                                  </select>
                            </div>
                            <div class="col">
                                <select class="form-select form-select-sm d text-primary fw-semibold" id="year_select"
                                data-id="year">
                                    <option class="d-none option_reset" id="option_reset_year" selected value="">&#xF17A; Year Level</option>
                                  </select>
                            </div>
                            <div class="col">
                                <select class="form-select form-select-sm d text-primary fw-semibold" id="section_select"
                                data-id="section">
                                    <option class="d-none option_reset" id="option_reset_section" selected value="">&#xF571; Section</option>
                                  </select>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-primary btn-sm" type="button" id="btn_filter_sorting">
                                    <i class="bi bi-search fw-bold me-2"></i>
                                    Filter</button>
                            </div>
                        </div>
                        {{-- student sorting --}}

                        {{-- student table --}}
                        <div class="row">
                            <div class="col mt-3">
                                <div class="card">
                                    <div class="car-body p-3">
                                        <table id="student_table_sorting" class="table bg-white rounded shadow-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Student ID</th>
                                                    {{-- <th>Institute</th> --}}
                                                    <th>Program Name</th>
                                                    {{-- <th>Section Name</th> --}}
                                                    <th>Year Level</th>
                                                    <th>Sex</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- student data here  --}}
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- student table --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- scroll to top --}}
        <div id="scroll-to-top-button_sorting" class="bg-success text-white py-2 px-3 rounded-circle">
            <i class="fas fa-arrow-up fw-bold fs-3"></i>
        </div>

        {{-- modal --}}
        @include('pages.admin.sorting.modal.view')
    </div>
    @section('javascript')
        @include('pages.admin.sorting.javascript.js')
    @endsection
@endsection