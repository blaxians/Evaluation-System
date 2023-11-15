@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4">
        <!-- title of the page start -->
        <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col py-2">
                <h3 class="m-0 fw-bold primary-text fs-4">Dean</h3>
            </div>
        </div>
        <!-- title of the page end -->

        <!-- table start -->
        <div class="row my-4 p-2">
            <div class="col p-0">
                <div class="card">
                    <div class="card-header d-flex justify-content-end">
                        <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#add_dean"><i
                                class="bi bi-plus-circle me-2"></i>New Dean</button>
                    </div>

                    <div class="card-body overflow-x-scroll" id="deans_table">
                        <div class="text-center">
                            <div class="spinner-border text-secondary my-5" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- table end -->

        {{-- modals start --}}
        @include('pages.admin.dean.modal.add')
        @include('pages.admin.dean.modal.edit')
        @include('pages.admin.dean.modal.view')
        {{-- modals end --}}
    </div>
@endsection

@section('javascript')
    @include('pages.admin.dean.javascript.js')
@endsection
