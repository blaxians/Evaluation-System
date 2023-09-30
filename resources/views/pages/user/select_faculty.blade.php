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
            <div class="col">
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between">
                        <h2 class="card-title text-success">Choose your prossefor</h2>
                        <button class="btn btn-success"><i class="bi bi-plus-circle me-2"></i>Add Professor</button>
                    </div>
                    <div class="card-body">
                        {{-- <h1 class="text-center text-success my-5">Hello mama</h1> --}}
                        <div class="p-2 border">
                            <table class="table table-hover hover-success" id="table">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th width="150">Checkbox</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Ralp Juts</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Ralp Juts</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Ralp Juts</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Ralp Juts</td>
                                        <td><input type="checkbox"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.scripts')
</body>
</html>