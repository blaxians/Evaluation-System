@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4">
        <!-- title of the page start -->
        <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col py-2">
                <h3 class="m-0 fw-bold primary-text fs-4" id="evaluation_report_title">Evaluation Report</h3>
            </div>
        </div>
        <!-- title of the page end -->


        <!-- table start -->
        <div class="row my-4 p-2">
            <div class="col">
                <div class="card">
                    <div class="card-body overflow-x-scroll" id="institute_card_report">

                    <div class="text-center">
                        <div class="spinner-border text-secondary my-5" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- table end -->

        {{-- modal start --}}
        @include('pages.admin.report.modal.view')
        {{-- modal end --}}

    </div>
@endsection
@section('javascript')
    @include('pages.admin.report.javascript.js')
@endsection
