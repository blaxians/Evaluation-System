@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4">
        <!-- title of the page start -->
        <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col py-2">
                <h3 class="m-0 fw-bold primary-text fs-4">Faculties</h3>
            </div>
        </div>
        <!-- title of the page end -->

        <!-- table start -->
        <div class="row my-5 p-2 border">
            <div class="col-12 my-2 d-flex justify-content-end">
                <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#add_faculties"><i
                        class="fa-solid fa-circle-plus"></i> New Faculties</button>
                @include('pages.admin.faculties.modal.add')
            </div>
            <div class="col overflow-x-scroll">
                <table class="table bg-white rounded shadow-sm  table-hover" id="table">
                    <thead>
                        <tr>
                            <th scope="col" width="50"></th>
                            <th scope="col">Last Name</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Middle Name</th>
                            <th scope="col">Institute</th>
                            <th scope="col" width="30px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faculties as $facultie)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $facultie->last_name }}</td>
                                <td>{{ $facultie->first_name }}</td>
                                <td>{{ $facultie->middle_name }}</td>
                                <td>{{ $facultie->institute }}</td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- table end -->
    </div>
@endsection
