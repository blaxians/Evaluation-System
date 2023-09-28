@extends('layout.user')
@section('user')
    <div class="container-fluid px-4">

        <!-- title of the page start -->
        <div class="row p-0 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col d-none d-sm-inline pt-3">
                <h3 class="m-0 fw-bold primary-text fs-4">Welcome</h3>
            </div>
            <div class="col align-items-center">
                <div class="row p-2 d-flex flex-nowrap">
                    <div class="col d-flex flex-shrink-1 align-items-center p-0 me-2">
                        <i
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


        <!-- table start -->
        <div class="row my-5 p-2 border">
            <h3 class="fs-4 mb-3 primary-text">Random Table</h3>
            <div class="col overflow-x-scroll">
                <table class="table bg-white rounded shadow-sm  table-hover" id="table">
                    <thead>
                        <tr>
                            <th scope="col" width="50">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Ian Blas</td>
                            <td>ianblas@gmail.com</td>
                            <td>09353306534</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Justin Bibe</td>
                            <td>justinbibe@gmail.com</td>
                            <td>09353306535</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Paul Jay Walker</td>
                            <td>pauljay@gmail.com</td>
                            <td>09353306536</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>Rock Solid</td>
                            <td>gobas@gmail.com</td>
                            <td>09353306537</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- table end -->

    </div>
@endsection