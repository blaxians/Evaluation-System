 <!-- navigation bar start -->
 <nav class="navbar navbar-expand-lg navbar-light p-3 border-bottom">
    <div class="d-flex align-items-center flex-shrink-1">
        <h2 class="fs-5 m-0 primary-text">Faculty Evaluation System</h2>
    </div>

    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-none d-sm-block">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Hello, <span class="fw-bold">Ian Blas</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                {{-- <li><a class="dropdown-item fs-6" href="#">Profile</a></li>
                <li><a class="dropdown-item fs-6" href="#">Settings</a></li> --}}
                <li><a class="dropdown-item fs-6" href="{{ route('logout') }}">Logout</a></li>
                <li><a class="dropdown-item fs-6" role="button" data-bs-toggle="modal"
                    data-bs-target="#change_password_user">Change Password</a></li>
            </ul>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-sm-none d-block">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-fill text-dark fs-4 align-self-baseline"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                {{-- <li><a class="dropdown-item fs-6" href="#">Profile</a></li>
                <li><a class="dropdown-item fs-6" href="#">Settings</a></li> --}}
                <li><a class="dropdown-item fs-6" href="{{ route('logout') }}">Logout</a></li>
                <li><a class="dropdown-item fs-6" role="button" data-bs-toggle="modal"
                    data-bs-target="#change_password_user">Change Password</a></li>
            </ul>
        </li>
    </ul>
</nav>

@include('pages.user.components.modal.change_pass')
@include('pages.user.components.javascript.js')

<!-- navigation bar end -->
