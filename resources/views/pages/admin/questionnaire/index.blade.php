@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4">
        <!-- title of the page start -->
        <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col py-2">
                <h3 class="m-0 fw-bold primary-text fs-4">Questionnaire</h3>
            </div>
        </div>
        <!-- title of the page end -->

        <!-- table start -->
        <div class="row my-4 p-2">
            <div class="col p-0">
                <div class="card">
                    <div class="card-header d-flex justify-content-end">
                        <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#add_question_modal"><i
                        class="bi bi-plus-circle me-2"></i>New Question</button>
                    </div>
                    <div class="card-body overflow-x-scroll" id="questionnaire_table">
                        <div class="text-center">
                            <div class="spinner-border text-secondary my-5"  role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- table end -->

        {{-- modals start --}}
        @include('pages.admin.questionnaire.modal.add')
        @include('pages.admin.questionnaire.modal.edit')
        {{-- modals end --}}
    </div>
@endsection

@section('javascript')
    @include('pages.admin.questionnaire.javascript.js')
@endsection
