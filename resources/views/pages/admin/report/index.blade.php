@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4">
        <!-- title of the page start -->
        <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col py-2">
                <h3 class="m-0 fw-bold primary-text fs-4">Evaluation Report</h3>
            </div>
        </div>
        <!-- title of the page end -->


        <!-- table start -->
        <div class="row my-4 p-2">
            <div class="col p-0">
                <div class="card">
                    <div class="card-body overflow-x-scroll" id="report_table">
                        {{-- <div class="text-center">
                            <div class="spinner-border text-secondary my-5" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div> --}}
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="my-3 text-center border-bottom pb-2">
                                            <img src="basc.jpg" class="img-thumbnail rounded-circle" width="100">
                                        </div>
                                        <div class="my-3 text-center">
                                            <h6 class="fw-semibold">Institute of Engineering and Applied Technology</h6>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-success btn-sm"><i class="bi bi-eye-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="my-3 text-center border-bottom pb-2">
                                            <img src="basc.jpg" class="img-thumbnail rounded-circle" width="100">
                                        </div>
                                        <div class="my-3 text-center">
                                            <h6 class="fw-semibold">Institute of Engineering and Applied Technology</h6>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-success btn-sm"><i class="bi bi-eye-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="my-3 text-center border-bottom pb-2">
                                            <img src="basc.jpg" class="img-thumbnail rounded-circle" width="100">
                                        </div>
                                        <div class="my-3 text-center">
                                            <h6 class="fw-semibold">Institute of Engineering and Applied Technology</h6>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-success btn-sm"><i class="bi bi-eye-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="my-3 text-center border-bottom pb-2">
                                            <img src="basc.jpg" class="img-thumbnail rounded-circle" width="100">
                                        </div>
                                        <div class="my-3 text-center">
                                            <h6 class="fw-semibold">Institute of Engineering and Applied Technology</h6>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-success btn-sm"><i class="bi bi-eye-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="my-3 text-center border-bottom pb-2">
                                            <img src="basc.jpg" class="img-thumbnail rounded-circle" width="100">
                                        </div>
                                        <div class="my-3 text-center">
                                            <h6 class="fw-semibold">Institute of Engineering and Applied Technology</h6>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-success btn-sm"><i class="bi bi-eye-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- table end -->

        {{-- modal start --}}
        
        {{-- modal end --}}

    </div>
@endsection
@section('javascript')
    @include('pages.admin.report.javascript.js')
@endsection
