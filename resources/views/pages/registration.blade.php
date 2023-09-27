<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layout.links')
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <title>BASC | Login</title>
</head>
<body style="background-image:url({{ asset('assets/img/main/bg-image.png') }});">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh" id="main-container">
        <form class="form ">
            <div class="d-flex mb-2 pb-2 justify-content-center justify-content-sm-start">
                <img src="{{ asset('assets/img/main/basc.png') }}" class="img-fluid rounded-circle me-2" width="45">
                <p class="title fw-semibold me-1">Register Students</p>
            </div>
            <label>
                <input class="input" type="text" placeholder="" required="">
                <span>Student number</span>
            </label> 
            <div class="flex flex-column flex-sm-row">

                <label>
                    <input class="input" type="text" placeholder="" required="">
                    <span>Firstname</span>
                </label>
        
                <label>
                    <input class="input" type="text" placeholder="" required="">
                    <span>Middlename</span>
                </label>

                <label>
                    <input class="input" type="text" placeholder="" required="">
                    <span>Lastname</span>
                </label>

            </div>  
                    
            <label>
                <input class="input" type="email" placeholder="" required="">
                <span>Email</span>
            </label> 
                
            <label>
                <input class="input" type="password" placeholder="" required="">
                <span>Password</span>
            </label>
            <label>
                <input class="input" type="password" placeholder="" required="">
                <span>Confirm password</span>
            </label>
            <div class="w-100 d-flex justify-content-center px-2">
                <button type="submit" class="btn btn-success rounded-5 px-3 px-sm-4">Submit</button>
            </div>
            <p class="signin">Already have an acount ? <a href="#">Signin</a> </p>
        </form>
        </div>
    </div>
    @include('layout.scripts')
</body>
</html>

