 <!-- navigation bar start -->
 <nav class="navbar navbar-expand-lg navbar-light p-3 border-bottom">
     <div class="d-flex align-items-center flex-shrink-1">
         <i class="fas fa-bars fs-4 me-3 primary-text" id="menu-toggle"></i>
         <h2 class="fs-5 m-0 primary-text">Faculty Evaluation System</h2>
     </div>

     <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-none d-sm-block">
         <li class="nav-item dropdown">
             <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                 Hello, <span class="fw-bold">Ian Blas</span>
             </a>
             <ul class="dropdown-menu dropdown-menu-end">
                 {{-- <li><a class="dropdown-item fs-6" href="#">Profile</a></li>
                <li><a class="dropdown-item fs-6" href="#">Settings</a></li> --}}
                 <li><a class="dropdown-item fs-6" href="{{ route('logout') }}">Logout</a></li>
             </ul>
         </li>
     </ul>
 </nav>
 <!-- navigation bar end -->
