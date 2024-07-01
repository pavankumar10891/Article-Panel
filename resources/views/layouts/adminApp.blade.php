<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />

    <!-- Vendors CSS --> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>  

<body>
    
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{route("home")}}" class="app-brand-link">
                    <span class="app-brand-logo demo"></span>
                    <span class="app-brand-text demo menu-text fw-bolder ms-2"><img class="logo" src="{{asset('assets/img/dr223.png')}}" alt="logo"></span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>
            <?php 
                $segment = Request::segment(1);
                $segment2 = Request::segment(2);
                $segment3 = Request::segment(3);
             ?>
            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item {{($segment == 'home')?'open active' :''}}">
                    <a href="{{route("home")}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Pages</span>
                </li>
            
                <!-- Layouts -->

                <li class="menu-item {{($segment == 'tasks')?'open active' :''}}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-user"></i>
                        <div data-i18n="Layouts">Task</div>
                    </a>

                    <ul class="menu-sub">
                    @if(Auth()->user()->hasRole('admin') || Auth()->user()->hasRole('Buyer'))
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 != 'create') || in_array($segment3, ['edit','show']) ?' active' :''}}">
                            <a href="{{route('tasks.index')}}" class="menu-link">
                                <div data-i18n="Without menu">All Task</div>
                            </a>
                        </li>
                        
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'create') ?'active' :''}}">
                            <a href="{{ route('tasks.create') }}" class="menu-link">
                                <div data-i18n="Without navbar">Add Task</div>
                            </a>
                        </li>
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'import') ?'active' :''}}">
                            <a href="{{ route('tasks.import') }}" class="menu-link">
                                <div data-i18n="Without navbar">Import Task</div>
                            </a>
                        </li>
                        
                        @endif
                        @if(Auth()->user()->hasRole('Writer'))
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'pending-task') ?'active' :''}}">
                            <a href="{{ route('tasks.pendingTask') }}" class="menu-link">
                                <div data-i18n="Without navbar">
                                Pending Task
                                </div>
                            </a>
                        </li>
                         @endif
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'assign') ?'active' :''}}">
                            <a href="{{ route('tasks.assign') }}" class="menu-link">
                                <div data-i18n="Without navbar">
                                Assigned Task  
                                </div>
                            </a>
                        </li>
                        
                       
                        @if(Auth()->user()->hasRole('Writer'))
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'complete-tasks') ?'active' :''}}">
                            <a href="{{ route('tasks.completeTask') }}" class="menu-link">
                                <div data-i18n="Without navbar">Completed Task</div>
                            </a>
                        </li>
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'rejected-task') ?'active' :''}}">
                            <a href="{{ route('tasks.rejectedTask') }}" class="menu-link">
                                <div data-i18n="Without navbar">Rejected</div>
                            </a>
                        </li>
                        @endif
                        @if(Auth()->user()->hasRole('admin') || Auth()->user()->hasRole('Buyer'))
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'unassign') ?'active' :''}}">
                            <a href="{{ route('tasks.unassign') }}" class="menu-link">
                                <div data-i18n="Without navbar">Unassign Task</div>
                            </a>
                        </li>
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'review-task') ?'active' :''}}">
                            <a href="{{ route('tasks.reviewTask') }}" class="menu-link">
                                <div data-i18n="Without navbar">Review Task</div>
                            </a>
                        </li>
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'complete-tasks') ?'active' :''}}">
                            <a href="{{ route('tasks.completeTask') }}" class="menu-link">
                                <div data-i18n="Without navbar">Completed Task</div>
                            </a>
                        </li>
                        {{--
                        <li class="menu-item {{ ($segment == 'tasks') && ($segment2 == 'report') ?'active' :''}}">
                            <a href="{{ route('tasks.report') }}" class="menu-link">
                                <div data-i18n="Without navbar">Report</div>
                            </a>
                        </li> --}}
                        @endif
                    </ul>
                </li>

            @if(Auth()->user()->hasRole('admin') || Auth()->user()->hasRole('Buyer'))
                <li class="menu-item {{($segment == 'writers')?'open active' :''}}">
                    <a href="{{route("writers.index")}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                        <div data-i18n="Analytics">Writer</div>
                    </a>
                </li>
            @endif    

            @if(Auth()->user()->hasRole('admin'))

                
                <!-- Layouts -->
                
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Users</span>
                </li>

                

                <li class="menu-item {{($segment == 'buyers')?'open active' :''}}">
                    <a href="{{route("buyers.index")}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                        <div data-i18n="Analytics">Buyers</div>
                    </a>
                </li>
                <li class="menu-item {{($segment == 'users')?'open active' :''}}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-user"></i>
                        <div data-i18n="Layouts">Users</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ ($segment == 'users') && ($segment2 != 'create') || in_array($segment3, ['edit','show']) ?' active' :''}}">
                            <a href="{{route('users.index')}}" class="menu-link">
                                <div data-i18n="Without menu">Users</div>
                            </a>
                        </li>
                        <li class="menu-item {{ ($segment == 'users') && ($segment2 == 'create') ?'active' :''}}">
                            <a href="{{ route('users.create') }}" class="menu-link">
                                <div data-i18n="Without navbar">Add User</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            </ul>
        </aside>
        <!-- / Menu -->
        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <nav
                class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar"
            >
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    @if(isset(auth()->user()->image) && file_exists(public_path('uploads/profile_pic/'.auth()->user()->image)))
                                    <img src="{{asset('uploads/profile_pic/'.auth()->user()->image)}}" alt class="w-px-40 h-auto rounded-circle" />
                                    @else
                                    <img src="{{ asset('assets/img/avatars/user.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                    @endif
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    @if(isset(auth()->user()->image) && file_exists(public_path('uploads/profile_pic/'.auth()->user()->image)))
                                                    <img src="{{asset('uploads/profile_pic/'.auth()->user()->image)}}" alt class="w-px-40 h-auto rounded-circle" />
                                                    @else
                                                    <img src="{{ asset('assets/img/avatars/user.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block">{{Auth()->user()->name}}</span>
                                                <small class="text-muted">{{ Auth::user()->getRoleNames()->first() }}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('profile')}}">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('profile')}}">
                                        <i class="bx bx-cog me-2"></i>
                                        <span class="align-middle">Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('logout')}}">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </nav>

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container container-p-y">
                    <div class="justify-content-center">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <!-- Content -->
                        @yield('content')
                        <!-- Content wrapper -->
                    </div>
                </div>
                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            @
                            <a href="#" target="_blank" class="footer-link fw-bolder">{{ config('app.name', 'Laravel') }}</a>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/vendor/js/menu.js')}}"></script>
<!-- Vendors JS -->
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<!-- Main JS -->
<script src="{{asset('assets/js/main.js')}}"></script>
<!-- Page JS -->
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>

@yield('script')

</body>
</html>
