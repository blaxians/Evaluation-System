@extends('layout.admin')
@section('admin')
<div class="container-fluid px-4" id="top_rated_per_insti">
    <!-- title of the page start -->
    <div class="row py-1 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
        <div class="col py-2">
            <h3 class="m-0 fw-bold primary-text fs-4">Top Rated per Institute</h3>
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
                        <select class="form-select w-25  form-select-sm" name="institute" aria-label="Default select example"
                        id="selected_top_rated_institute">
                            <option selected disabled>Select here</option>
                            <option value="College of Agriculture">College of Agriculture</option>
                            <option value="Institute of Arts and Sciences">Institute of Arts and Sciences</option>
                            <option value="Institute of Engineering and Applied Technology">Institute of Engineering and Applied Technology</option>
                            <option value="Institute of Education">Institute of Education</option>
                            <option value="Institute of Management">Institute of Management</option>
                            
                        </select>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="my-3 text-center" id="totoal_faculty">
                    </div>
                    <div class="row g-4" id="top_rated_per_institute_card">
                        <div class="h1 my-5 text-secondary text-center">Select Institute</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- top rated content  end --}}

</div>


    {{-- modal  --}}
    @include('pages.admin.institute.modal.top_faculty')
    {{-- modal  --}}
    
@endsection

@section('javascript')
    @include('pages.admin.institute.javascript.js')
@endsection
