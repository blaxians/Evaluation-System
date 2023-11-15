@extends('layout.admin')
@section('admin')
    <div class="container-fluid px-4" id="top_rated_facultys">
        <!-- title of the page start -->
        <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col py-2">
                <h3 class="m-0 fw-bold primary-text fs-4">Top Rated</h3>
            </div>
        </div>
        <!-- title of the page end -->

        {{-- top rated content  --}}
        <div class="row">
            <div class="col">
                <div class="card my-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h6 class="me-2 fw-semibold">Sort by:</h6>
                            <select class="form-select w-25  form-select-sm" name="selected" aria-label="Default select example"
                            id="selected_top_rateds">
                                <option selected disabled>Select here</option>
                                <option value="all">All</option>
                                <option value="student">Student</option>
                                <option value="dean">Dean</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body p-3" id="table_top_rated_eval">
                        <div class="h1 my-5 text-secondary text-center">Loading..</div>
                    </div>
                </div>
            </div>
        </div>
        {{-- top rated content  end --}}

    </div>

    {{-- modal  --}}
    @include('pages.admin.rated.modal.top_faculty')
    {{-- modal  --}}
    
@endsection

@section('javascript')
    @include('pages.admin.rated.javascript.js')
@endsection
