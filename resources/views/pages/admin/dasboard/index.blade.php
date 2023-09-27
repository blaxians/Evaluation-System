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
                    <div class="col d-flex flex-shrink-1 align-items-center p-0 me-2">
                        <i data-bs-toggle="modal" data-bs-target="#year_sem_set"
                            class="fas ms-2 ms-sm-auto fa-calendar fs-4 primary-text p-2 rounded-1 second-text secondary-bg"></i>
                    </div>
                    <div class="col p-0">
                        <div class="m-0 fs-6 fw-semibold primary-text">Academic Year</div>
                        <div class="m-0 fs-6 primary-text text-nowrap">2023-2024 1st Semester</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- title of the page end -->

        <!-- widgets start -->
        <div class="row g-4 mt-1" id="widget">
            <div class="col-md-3">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                    <i class="fas fa-chalkboard-teacher fs-1 second-text border rounded-circle secondary-bg p-3"></i>
                    <div>
                        <h3 class="fs-2 fw-bold primary-text">720</h3>
                        <p class="primary-text">Faculties</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                    <i class="fas fa-users fs-1 second-text border rounded-circle secondary-bg p-3"></i>
                    <div>
                        <h3 class="fs-2 fw-bold primary-text">4920</h3>
                        <p class="primary-text">Students</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                    <i class="fas fa-book-open fs-1 second-text border rounded-circle secondary-bg p-3"></i>
                    <div>
                        <h3 class="fs-2 fw-bold primary-text">3899</h3>
                        <p class="primary-text">Classes</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                    <i class="fas fa-user fs-1 second-text border rounded-circle secondary-bg p-3"></i>
                    <div>
                        <h3 class="fs-2 fw-bold primary-text">3467</h3>
                        <p class="primary-text">Users</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- widgets end -->

    </div>
@endsection
