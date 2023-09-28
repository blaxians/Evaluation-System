@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4">
        <!-- title of the page start -->
        <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col py-2">
                <h3 class="m-0 fw-bold primary-text fs-4">Student</h3>
            </div>
        </div>
        <!-- title of the page end -->

        <!-- table start -->
        <div class="row my-5 p-2 border">
            <div class="col overflow-x-scroll">
                <table class="table bg-white rounded shadow-sm  table-hover" id="table">
                    <thead>
                        <tr>
                            <th scope="col" width="50"></th>
                            <th scope="col">Student ID</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Middle Name</th>
                            <th scope="col">Status</th>
                            <th scope="col" width="30px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- table end -->
    </div>
@endsection
