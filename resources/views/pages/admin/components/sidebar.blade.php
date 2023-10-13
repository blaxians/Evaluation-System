<!-- sidebar start -->
<div class="bg-white" id="sidebar-wrapper">

    <div class="sidebar-heading py-4 fs-4 fw-bold text-uppercase">
        <i class="fas fa-gift me-2"></i>basclogo
    </div>

    <div class="list-group list-group-flush my-3">
        <a href="{{ route('index.dashboard') }}"
            class="list-group-item py-3 ps-5 list-group-item-action fw-bold text-secondary nav-link
        {{ request()->is('dashboard') ? 'text-success' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </a>
        <a href="{{ route('index.questionnaire') }}"
            class="list-group-item py-3 ps-5 list-group-item-action text-secondary fw-bold nav-link 
        {{ request()->is('questionnaire') ? 'text-success' : '' }}">
            <i class="fas fa-list me-2"></i>Questionnaire
        </a>
        <a href="{{ route('index.faculties') }}"
            class="list-group-item py-3 ps-5 list-group-item-action text-secondary fw-bold nav-link
        {{ Request::segment(1) === 'faculties' ? 'text-success' : '' }}">
            <i class="fas fa-chalkboard-teacher me-2"></i>Faculties
        </a>
        <a href="{{ route('index.dean') }}"
            class="list-group-item py-3 ps-5 list-group-item-action text-secondary fw-bold nav-link
        {{ Request::segment(1) === 'dean' ? 'text-success' : '' }}">
            <i class="fa-solid fa-user-tie me-2"></i>Dean's
        </a>
        <a href="{{ route('index.student') }}"
            class="list-group-item py-3 ps-5 list-group-item-action text-secondary fw-bold nav-link 
        {{ Request::segment(1) === 'students' ? 'text-success' : '' }}">
            <i class="fas fa-users me-2"></i>Students
        </a>
        <a href="{{ route('index.report') }}"
            class="list-group-item py-3 ps-5 list-group-item-action text-secondary fw-bold nav-link
        {{ Request::segment(1) === 'report' ? 'text-success' : '' }}">
            <i class="fas fa-file-invoice me-2"></i>Evaluation Report
        </a>
        <a href="{{ route('import.student') }}"
            class="list-group-item py-3 ps-5 list-group-item-action text-secondary fw-bold nav-link
        {{ Request::segment(1) === 'import' ? 'text-success' : '' }}">
            <i class="fas fa-user-friends me-2"></i>Import Student
        </a>

        <button class="dropdown-btn py-3 ps-5 text-secondary fw-bold fs-6 text-dark d-md-none">
            <i class="fa fa-caret-down"></i>Hi, ian blas
        </button>
        <div class="dropdown-container ms-2">
            {{-- <a href="#" class="list-group-item ps-5 py-2  list-group-item-action fs-6 nav-link">
                Profile
            </a>
            <a href="#" class="list-group-item ps-5 py-2  list-group-item-action fs-6 nav-link">
                Settings
            </a> --}}
            <a href="{{ route('logout') }}" class="list-group-item ps-5 py-2  list-group-item-action fs-6 nav-link">
                Logout
            </a>
        </div>


    </div>
</div>
<!-- sidebar end -->
