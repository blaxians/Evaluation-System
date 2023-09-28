@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4">
        <!-- title of the page start -->
        <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col py-2">
                <h3 class="m-0 fw-bold primary-text fs-4">Dean's</h3>
            </div>
        </div>
        <!-- title of the page end -->

        <!-- table start -->
        <div class="row my-5 p-2 border">
            <div class="col-12 my-2 d-flex justify-content-end">
                <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#add_question"><i
                        class="fa-solid fa-circle-plus"></i> New Dean</button>
            </div>
            <div class="col overflow-x-scroll">
                <table class="table bg-white rounded shadow-sm  table-hover" id="table">
                    <thead>
                        <tr>
                            <th scope="col" width="50"></th>
                            <th scope="col">Name</th>
                            <th scope="col">Institute</th>
                            <th scope="col" width="30px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deans as $dean)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dean->name }}</td>
                                <td>{{ $dean->institute }}</td>
                                {{-- EDIT PASSWORD --}}
                                <td><button class="btn btn-secondary btn-sm">Edit</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- table end -->
    </div>
@endsection
