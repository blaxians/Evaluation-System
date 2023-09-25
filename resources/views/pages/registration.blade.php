<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layout.links')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <title>BASC | Login</title>
</head>
<body style="background-image:url({{ asset('assets/img/main/basc_background.jpg') }});">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh" id="main-container">
        <div class="row main-card mx-4" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;" style="width:100vw;">

            <div class="col-md-6 p-5 row-logo d-flex flex-column justify-content-center align-items-center" id="logo-wrapper">
                <img src="{{ asset('assets/img/main/basc.png') }}" class="img-fluid rounded-circle" width="200" id="logo-basc">
                <p class="m-0 mt-2 fw-medium text-center text-light">Powered by M I S.</p>
            </div>

            <div class="col-md-6 row-login bg-light d-flex px-0 bg-white justify-content-center">

                <div class="card border-0 bg-light mt-5 bg-transparent" id="card">
                    <div class="card-body p-0 px-4 pb-1">
                        <h5 class="card-title mb-4 text-nowrap fs-5 fw-semibold text-success">Register your account</h5>

                        <form action="#" method="post">
                            <div class="group mb-3">
                                <input required="" type="text" class="input">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label class="text-success">ID number</label>
                            </div>

                            <div class="group mb-3">
                                <input required="" type="text" class="input">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label class="text-success">Name</label>
                              </div>

                            <div class="group mb-3">
                                <input required="" type="text" class="input">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label class="text-success">Email</label>
                              </div>

                            <div class="group mb-3">
                                <input required="" type="password" class="input">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label class="text-success">Password</label>
                              </div>

                            <div class="group mb-3">
                                <input required="" type="password" class="input">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label class="text-success">Confirm password</label>
                              </div>
                        </form>

                        <div class="mt-5">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <button class="btn btn-success btn-sm btn-bg  rounded-4 mb-4 login-button"><span class="px-4">Register</span></button>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.scripts')
</body>
</html>

