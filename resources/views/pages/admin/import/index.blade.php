@extends('layout.admin')
@section('admin')
    <div class="container">
        <form action="{{ route('import.post') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-check">
                <input class="form-control" type="file"
                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="importedFile" required>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-5">
                    <div class="row">
                        <button type="submit" class="form-control btn btn-success btn-md"><i
                                class="fa-solid fa-upload"></i> Upload</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
