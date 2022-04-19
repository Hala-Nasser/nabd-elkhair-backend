<!DOCTYPE html>
<html dir="rtl">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link rel="icon" href="{{ asset('dist/img/logo.png') }}" type="image/x-icon">
  @yield('title')

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Bootstrap 4 RTL -->
  <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
  <!-- Custom style for RTL -->
  <link rel="stylesheet" href="dist/css/custom.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    .layout-fixed .main-sidebar {
      right: 0;
    }

    .mr-auto-navbav {
      margin-right: auto !important;
    }

    .content-wrapper,
    .main-footer,
    .main-header {
      margin-left: 0px;
      margin-right: 250px;
    }


    .content-wrapper,
    .main-footer,
    .main-header {
      transition: margin-left .3s ease-in-out;
      margin-left: 0px;
      z-index: 3000;
    }
  </style>
  @yield('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">



      <!-- Right navbar links -->
      <ul class="navbar-nav mr-auto-navbav">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-gear"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header" style="display: block;">
              <div style="display: inline-block">
                <div class="image" style="display: inline-block">
                  <img src=" {{ asset('dist/img/admin.jpg') }}" class="img-circle elevation-2" alt="User Image"
                    style="width:40px; height:40px; object-fit: cover; display: inline-block">
                </div>
                <div class="info" style="vertical-align: middle; display: inline-block; margin-right: 5px;">
                  <p style="color: rgb(0, 0, 0);">{{ Auth::user()->name }}</p>
                </div>
              </div>
            </span>
            <div class="dropdown-divider"></div>
            <span class="dropdown-item dropdown-header" style="display: block;">
              <form method="post" action="{{ URL(route('logout')) }}">
                @csrf
                <i class="fa fa-sign-out mr-2" style="vertical-align: middle;"></i>
                <button type="submit" class="btn btn-primary"
                  style="border: none; background: transparent; color:black; vertical-align: middle;">
                  تسجيل الخروج
                </button>
              </form>
            </span>

          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->

      <a href="" class="brand-link">
        <div style="display: inline;">
          <img src=" {{ asset('dist/img/logo.png') }}" class="img-circle elevation-2" alt="User Image"
            style="width:50px; height:50px; padding: 5px 10px 5px 10px; background-color:#fff;">
        </div>
        <span class="brand-text font-weight-light"
          style="color: #fff; margin-right: 5px; font-size:24px; font-weight:bolder">نبض الخير</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="{{ URL('home') }}" class="nav-link" id="home">

                <!--  <i class="fas fa-th-large"></i> -->
                <i>
                  <img src="{{ asset('home.png') }}" style="width: 20px; height:20px;">
                </i>
                <p style="color: #fff; margin-right:5px;">
                  الرئيسية
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ URL('charity') }}" class="nav-link" id="charity">

                <!--  <i class="fas fa-th-large"></i> -->
                <i>
                  <img src="{{ asset('charity.png') }}" style="width: 20px; height:20px;">
                </i>
                <p style="color: #fff; margin-right:5px;">
                  الجمعيات
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ URL('donationtype') }}" class="nav-link" id="donationtype">
                <i>
                  <img src="{{ asset('donation_type.png') }}" style="width: 20px; height:20px;">
                </i>
                <p style="color: #fff; margin-right:5px">
                  أنواع التبرع
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ URL('donor') }}" class="nav-link" id="donor">
                <i>
                  <img src="{{ asset('donor.png') }}" style="width: 20px; height:20px;">
                </i>
                <p style="color: #fff; margin-right:5px">
                  المتبرعين
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ URL('complaint') }}" class="nav-link" id="Complaints">
                <i>
                  <img src="{{ asset('complaints.png') }}" style="width: 20px; height:20px;">
                </i>
                <p style="color: #fff; margin-right:5px;">
                  الشكاوي
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" id="static_pages">
                <img src="{{ asset('static.png') }}" style="width: 20px; height:20px;">
                <p style="color: #fff; margin-right:5px;">
                  إدارة الصفحات الثابتة
                  
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ URL('static/1') }}" class="nav-link" id="aboutapp">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color: #fff; margin-right:5px; font-size:14px;">عن التطبيق</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ URL('static/2') }}" class="nav-link" id="privacypolicy">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color: #fff; margin-right:5px; font-size:14px;">سياسة الاستخدام</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ URL('static/3') }}" class="nav-link" id="onboarding1">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color: #fff; margin-right:5px; font-size:14px;">شاشة الترحيب الاولى</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ URL('static/4') }}" class="nav-link" id="onboarding2">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color: #fff; margin-right:5px; font-size:14px;">شاشة الترحيب الثانية</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ URL('static/5') }}" class="nav-link" id="onboarding3">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="color: #fff; margin-right:5px; font-size:14px;">شاشة الترحيب الثالثة</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
{{-- 
    @if(Session::has('success'))


    {{dd(Session::get('success'))}}
    <div class="alert alert-success alert-dismissible fade show" style="background-color: #E3FCEF ;color: #003348;" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong></strong> {{ Session::get('success') }}
    </div>
@endif
@if (\Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Error !</strong>  {!! \Session::get('error') !!}
    </div>
@endif
@if (Session::has('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>Note !</strong>{!! Session::get('warning') !!}
    </div>
@endif --}}
  
    @yield('content')

    <footer class="main-footer">
      nabd elkhair &copy; 2022
      <div class="float-right d-none d-sm-inline-block">
        Version 1.0.0
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->


  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('dist/js/demo.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function () {
      @if (\Request::url() == URL('home'))
      $('#home').addClass('active');
    @elseif (\Request::url() == URL('charity'))
      $('#charity').addClass('active');
    @elseif (\Request::url() == URL('donationtype'))
      $('#donationtype').addClass('active');
    @elseif (\Request::url() == URL('donor'))
      $('#donor').addClass('active');
    @elseif (\Request::url() == URL('Complaint'))
      $('#Complaint').addClass('active');
      @elseif (\Request::url() == URL('about'))
      $('#aboutapp').addClass('active');
      $('#static_pages').addClass('active');
    @elseif (\Request::url() == URL('privacy'))
      $('#privacypolicy').addClass('active');
      $('#static_pages').addClass('active');
    @elseif (\Request::url() == URL('onboarding1'))
      $('#onboarding1').addClass('active');
      $('#static_pages').addClass('active');
    @elseif (\Request::url() == URL('onboarding2'))
      $('#onboarding2').addClass('active');
      $('#static_pages').addClass('active');
      @elseif (\Request::url() == URL('onboarding3'))
      $('#onboarding3').addClass('active');
      $('#static_pages').addClass('active');
    @endif
  });
  </script>

@yield('js')

</body>

</html>