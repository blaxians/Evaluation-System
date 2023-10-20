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
                        <div>
                            <ul class="nav nav-tabs fw-semibold">
                                <li class="nav-item">
                                  <a class="nav-link text-capitalize active" role="button" id="campus_select_main">Main</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link text-capitalize" role="button" id="campus_select_btvc">Btvc</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link text-capitalize" role="button" id="campus_select_drt">Drt</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link text-capitalize" role="button" id="campus_select_balagtas">Balagtas</a>
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
                        <div class="row g-2 d-flex">
                            <div class="col">
                                <select class="form-select form-select-sm text-primary fw-semibold" id="institute_select">
                                    <option class="d-none" id="option_reset_institute" selected value="">&#xF876; Institute</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select form-select-sm d text-primary fw-semibold" id="course_select">
                                    <option class="d-none option_reset" id="option_reset_course" selected value="">&#xF6FD; Course</option>
                                  </select>
                            </div>
                            <div class="col">
                                <select class="form-select form-select-sm d text-primary fw-semibold" id="year_select">
                                    <option class="d-none option_reset" id="option_reset_year" selected value="">&#xF17A; Year Level</option>
                                  </select>
                            </div>
                            <div class="col">
                                <select class="form-select form-select-sm d text-primary fw-semibold" id="section_select">
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
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Student ID</th>
                                                    <th>Name</th>
                                                    <th>Couse</th>
                                                    <th>Year</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>100023</td>
                                                    <td>Ian Jhon Blas</td>
                                                    <td>BSIT</td>
                                                    <td>4</td>
                                                    <td>Done</td>
                                                    <td>Edit | Delete</td>
                                                </tr>
                                                <tr>
                                                    <td>100023</td>
                                                    <td>Ian Jhon Blas</td>
                                                    <td>BSIT</td>
                                                    <td>4</td>
                                                    <td>Done</td>
                                                    <td>Edit | Delete</td>
                                                </tr>
                                                <tr>
                                                    <td>100023</td>
                                                    <td>Ian Jhon Blas</td>
                                                    <td>BSIT</td>
                                                    <td>4</td>
                                                    <td>Done</td>
                                                    <td>Edit | Delete</td>
                                                </tr>
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



    </div>
    @section('javascript')
        @include('pages.admin.sorting.javascript.js')
    @endsection
@endsection