@extends('layout.admin')
@section('custom_css')
<style>
    .center-align {
        text-align: center;
    }
</style>

@endsection
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
        <div class="row my-4 p-2">
            <div class="col p-0">
                <div class="card">
                    <div class="card-body overflow-x-scroll">
                        <table id="student_table" class="table bg-white rounded shadow-sm table-hover d-none">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th style="text-align:center;">View / Reset</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="text-center" id="spinner_loader_stud">
                            <div class="spinner-border text-secondary my-5"  role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- table end -->

        {{-- modal start --}}
        @include('pages.admin.student.modal.view')
        {{-- modal end --}}

    </div>
@endsection
@section('javascript')
    @include('pages.admin.student.javascript.js')
@endsection

