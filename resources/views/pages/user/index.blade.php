@extends('layout.user')
@section('user')
    <div class="container-fluid px-4">

        <!-- title of the page start -->
        <div class="row p-0 m-0 mt-3 bg-white rounded d-flex shadow-sm flex-shrink-0">
            <div class="col d-none d-sm-inline pt-3">
                <h3 class="m-0 fw-bold primary-text fs-4">Welcome</h3>
            </div>
            <div class="col align-items-center">
                <div class="row p-2 d-flex flex-nowrap">
                    <div class="col d-flex flex-shrink-1 align-items-center p-0 me-2">
                        <i
                            class="fas ms-2 ms-sm-auto fa-calendar fs-4 primary-text p-2 rounded-1 second-text secondary-bg"></i>
                    </div>
                    <div class="col p-0">
                        <div class="m-0 fs-6 fw-semibold primary-text">Academic Year</div>
                        <div class="m-0 fs-6 primary-text text-nowrap">2023-2024 1st Semester</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- title of the page end -->

        <div class="row mt-3">
            <div class="col">
                <div class="card rounded">
                    <div class="card-header bg-white d-flex">
                        <h3 class="card-title text-success m-0 p-2">Evaluate Professor</h3>
                    </div>
                    <div class="card-body" id="evaluate_professor_table">
                        <h1 class="text-center text-secondary my-5">Loading...</h1>
                    </div>
                </div>
            </div>
        </div>

        


        <!-- table start -->
        {{-- <div class="row my-5 p-2 border">
            <h3 class="fs-4 mb-3 primary-text">Random Table</h3>
            <div class="col overflow-x-scroll">
                <form action="{{ route('evaluate.user', 1) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <table class="table bg-white rounded shadow-sm  table-hover" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faculties as $faculty)
                                <tr>
                                    <td>{{ $faculty->question }}</td>
                                    <td>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="{{ 'question' . '-' . $faculty->id }}" value="1"
                                                id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Default radio
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="{{ 'question' . '-' . $faculty->id }}" value="2"
                                                id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Default radio
                                            </label>
                                        </div>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit">adasd</button>
                </form>
            </div>
        </div> --}}
        <!-- table end -->

    </div>
@endsection

@section('javascript')
    @include('pages.user.javascript.js')
@endsection



