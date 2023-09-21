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
        <div class="row main-card" style="height:350px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">
            <div class="col-7 p-5 row-logo d-flex flex-column justify-content-center align-items-center">
                <img src="{{ asset('assets/img/main/basc.png') }}" class="img-fluid rounded-circle" width="200">
                <p class="m-0 mt-auto fw-medium text-center text-light">Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="col-5 row-login bg-light d-flex px-0 bg-white">

                <div class="card border-0 bg-light mt-5 bg-transparent">
                    <div class="card-body p-0 px-4 pb-1">
                        <h5 class="card-title mb-4 text-nowrap fs-5 fw-semibold text-success">Login your account</h5>

                        <form action="#" method="post">
                            <div class="group mb-3">
                                <input required="" type="text" class="input">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label class="text-success">Username</label>
                            </div>

                            <div class="group">
                                <input required="" type="password" class="input">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label class="text-success">Password</label>
                              </div>
                        </form>

                        <div class="mt-5">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <button class="btn btn-success btn-sm btn-bg  rounded-4 mb-4 login-button"><span class="px-4">Login</span></button>
                                <a href="#" class="forgot-pass link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Forgot Password?</a>
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

