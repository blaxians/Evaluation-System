@extends('layout.admin')
@section('custom_css')
<style>
        
        #loading_overlay {
                    position: absolute;
                    padding-bottom: 50px;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(255, 255, 255, 0.7); 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                }

</style>
@endsection
@section('admin')

    {{-- <div class="container">
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
    </div> --}}

    <div class="container-fluid h-100">
        <div class="row px-4">
            <div class="bg-light rounded px-4 shadow-sm mt-3">
                <div class="row mt-3">
                    <div class="my-2 d-flex flex-column align-items-center">
                        <h2 class="">Import Student Data</h2>
                        <p>Submit is allowed only in case the user uploads a valid file.</p>
                    </div>
                    <form action="#" method="post" enctype="multipart/form-data" id="upload_excel">
                        @csrf
                        <div class="card">
                            <div class="my-4 text-center">
                                <input type="file" id="importedFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="importedFile" required style="display: none;">
                                <label for="importedFile" style="cursor: pointer;">
                                    <i class="fas fa-upload border p-3 rounded-1 text-dark" style="font-size: 120px"></i>
                                </label>
                                <p id="file-name" class="fs-5"></p>
                                <div id="loading_overlay" class="d-none">
                                    <div class="spinner-border d-none" role="status" id="spinner_upload">
                                        <span class="visually-hidden">Loading...</span>
                                      </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="fs-5">Only excel files allowed! (.xlsx)</p>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="px-5 d-flex justify-content-center">
                                <button type="submit" id="uploadButton" class="form-control btn btn-success btn-md" style="width: 7rem">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('javascript')
    @include('pages.admin.import.javascript.js')
@endsection

{{-- design --}}

