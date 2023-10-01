<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layout.links')
    <title>select faculty</title>
</head>
<body>
    
    <div class="container" style="height:100vh;">
        <div class="row">
            <div class="col my-3">
                <div class="alert alert-success fw-semibold" role="alert">
                    Before you start evaluating, make sure to select all of your professors 
                    by checking the checkboxes and then click the <strong>submit</strong> button.
                  </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-end justify-content-sm-between">
                        <h2 class="card-title text-success d-none d-sm-block">Sellect professor</h2>
                        <button id="btn_prof_finalize" class="btn btn-success"
                        data-bs-toggle="modal" data-bs-target="#add_professor"><i class="bi bi-check-circle me-2"></i>Finalize</button>
                    </div>
                    <div class="card-body" id="faculties_table">
                    </div>
                </div>
            </div>
        </div>

        {{-- modals start--}}
        @include('pages.user.modal.add')
        {{-- modals end--}}
    </div>
    @include('layout.scripts')
    @include('pages.user.javascript.scripts')
</body>
</html>