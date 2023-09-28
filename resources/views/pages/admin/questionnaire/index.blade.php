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
        <div class="row my-5 p-2 border">
            <div class="col-12 my-2 d-flex justify-content-end">
                <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#add_question_modal"><i
                        class="fa-solid fa-circle-plus"></i> New Question</button>
                @include('pages.admin.questionnaire.modal.add')
            </div>
            <div class="col overflow-x-scroll" id="questionnaire_table">
            </div>
        </div>
        <!-- table end -->
    </div>
@endsection

@section('javascript')
    @include('pages.admin.questionnaire.javascript.js')
@endsection
