@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4">

        <!-- title of the page start -->
        <div class="row p-0 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col d-none d-sm-inline pt-3">
                <h3 class="m-0 fw-bold primary-text fs-4">Dashboard</h3>
            </div>
            <div class="col align-items-center">
                <div class="row p-2 d-flex flex-nowrap">
                    <div class="col d-flex flex-shrink-1 justify-content-end p-0 me-2">
                       <div class="dropdown" id="year_dropdown">
                            <a role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas ms-2 ms-sm-auto fa-calendar fs-4 primary-text p-2 rounded-1 second-text secondary-bg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                
                                <li><a role="button" class="dropdown-item fs-6" href="#" id="btn_update_year">Update Academic Year</a></li>
                                    <li><a role="button" class="dropdown-item fs-6" href="#"
                                        data-bs-toggle="modal" data-bs-target="#edit_sem">Edit Semester</a></li>
                            </ul>
                       </div>
                    </div>
                    <div class="col p-0">
                        <div class="m-0 fs-6 fw-semibold primary-text">Academic Year</div>
                        <div class="m-0 fs-6 primary-text d-flex text-nowrap">
                            <div class="p-0 m-0 fs-6" id="academic_year">
                                {{-- academic year --}}
                            </div> 
                            <a href="#" role="button" class="p-0 primary-text fs-6 ms-1" 
                            data-bs-toggle="modal" data-bs-target="#edit_sem" id="semester">
                                {{-- semester --}}
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- title of the page end -->

        <!-- widgets start -->
        <div class="row g-4 mt-1" id="widget">
            <div class="col-md-6">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-evenly align-items-center rounded h-100">
                    <i class="fas fa-chalkboard-teacher fs-1 second-text border rounded-circle secondary-bg p-3"></i>
                    <div class="d-flex flex-column align-items-center">
                        <h3 class="fs-1 fw-bold primary-text" id="dashboard_total_faculties"><i class="bi bi-dash-lg"></i></h3>
                        <p class="primary-text fs-5">Total Faculties</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-evenly align-items-center rounded h-100">
                    <i class="fas fa-users fs-1 second-text border rounded-circle secondary-bg p-3"></i>
                    <div class="d-flex flex-column align-items-center">
                        <h3 class="fs-1 fw-bold primary-text" id="dashboard_total_students"><i class="bi bi-dash-lg"></i></h3>
                        <p class="primary-text fs-5">Total Students</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- widgets end -->

        {{-- statistics charts start  --}}
        <div class="row mt-1 g-4 d-flex">

            {{-- dean and student done pending  --}}
            <div class="col-lg-6">
                <div class="p-2 bg-white rounded shadow-sm h-100 d-flex justify-content-center align-items-center">
                    <div class="row g-4 d-none" id="student_dean_dougnut">
                       <div class="col-sm-6">

                           <div id="deansChart">
                               <canvas id="deansCanvas" style="width:296px; height:250px;"></canvas>
                               <div class="d-flex justify-content-center">
                                    <h6 class="fw-semibold fs-6 m-0">Dean</h5>
                               </div>
                           </div>

                       </div>
                       <div class="col-sm-6">

                           <div id="studentsChart">
                               <canvas id="studentsCanvas" style="width:296px; height:250px;"></canvas>
                               <div class="d-flex justify-content-center">
                                    <h6 class="fw-semibold fs-6 m-0">Student</h6>
                                </div>
                           </div>
                           
                       </div>
                    </div>
                    <div class="spinner-border text-secondary fw-semibold my-5" role="status" id="dougnut_chart_load">
                        <span class="visually-hidden">Loading...</span>
                      </div>
               </div>
            </div>
            {{-- dean and student done pending end  --}}

            {{-- faculty bar chart  --}}
            <div class="col-lg-6">
                <div class="p-2 bg-white rounded shadow-sm h-100 d-flex justify-content-center align-items-center">
                    <canvas id="facultyChart" class="d-none"></canvas>
                    <div class="spinner-border text-secondary fw-semibold" role="status" id="barchart_faculty_load">
                        <span class="visually-hidden">Loading...</span>
                      </div>
                </div>
            </div>
            {{-- faculty bar chart end  --}}
        </div>
        
        {{-- top rated faculty  --}}
        <div class="row mt-1 g-4 px-2">
            <div class="col bg-white rounded shadow-sm h-100 d-flex flex-column p-4 mb-4" style="height:300px;">
                <h3 class="py-2 fw-semibold">Top Rated Faculties</h3>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th scope="col" width="200">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1
                            <i class="bi bi-trophy-fill ms-3 text-warning fs-4"></i>
                            <i class="bi bi-trophy-fill text-warning fs-4"></i>
                            <i class="bi bi-trophy-fill text-warning fs-4"></i></th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                      <tr>
                        <th scope="row">2<i class="bi bi-trophy-fill ms-3 text-warning fs-4"></i>
                            <i class="bi bi-trophy-fill text-warning fs-4"></i></th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                      </tr>
                      <tr>
                        <th scope="row">3<i class="bi bi-trophy-fill ms-3 text-warning fs-4"></i></th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                      </tr>
                    </tbody>
                  </table>
            </div>
            {{-- top rated faculty  --}}
        </div>
        {{-- statistics charts end  --}}


        {{-- modals start --}}
       
        @include('pages.admin.dasboard.modal.edit')
        {{-- modals end --}}

    </div>
@endsection

@section('javascript')
    @include('pages.admin.dasboard.javascript.js')
@endsection
