<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @yield('title')

  @yield('css')

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar top bar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <h3>Happy Shopping</h3>
      </li>
      
    </ul>

    <div style="position: center ;display: flex;  flex-grow: 1; flex-basis: 0; justify-content: flex-end; ">
       @yield('search')

    <div class="link-icons" style="margin-right: 20px;">
                <form method="post" action="{{ URL(route('logout'))}}">
                    @csrf
                        <button class="fas fa-sign-out-alt" style="border: none; background: transparent;" />
                </form>
            </div>
      
    </div>

   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="{{ asset('dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">Happy Shopping</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src=" {{ asset('dist/img/admin.jpg') }}" class="img-circle elevation-2" alt="User Image" style="width:40px; height:40px; object-fit: cover;">
        </div>
        <div class="info" style="vertical-align: middle;">
          <p style="color: #fff;">{{ Auth::user()->name }}</p>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ URL('category') }}" class="nav-link" id="category">

            <!--  <i class="fas fa-th-large"></i> -->
              <i class="fas fa-th"></i>
              <p>
                Categories
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ URL('store') }}" class="nav-link" id="store">
            	<i class="fas fa-store"></i>
              <p>
                Stores
              </p>
            </a>
          </li>
            <li class="nav-item">
            <a href="#" class="nav-link" id="form">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ URL('category/create') }}" class="nav-link" id="category-create">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ URL('store/create') }}" class="nav-link" id="store-create">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add store</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ URL('store/rate') }}" class="nav-link" id="store-rate">
            	<i class="fas fa-star"></i>
              <p>
                Rating
              </p>
            </a>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

@yield('content')

  <footer class="main-footer" >
    <strong>Copyright &copy; 2021 <a href="">HappyShopping.com</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

@yield('js')
</body>


<script type="text/javascript">
  $(document).ready(function () {
    @if (\Request::url() == URL('category'))
      $('#category').addClass('active');
    @elseif (\Request::url() == URL('store'))
      $('#store').addClass('active');
    @elseif (\Request::url() == URL('category/create'))
      $('#category-create').addClass('active');
      $('#form').addClass('active');
    @elseif (\Request::url() == URL('store/create'))
      $('#store-create').addClass('active');
      $('#form').addClass('active');
      @elseif (\Request::url() == URL('store/rate'))
      $('#store-rate').addClass('active');
    @endif
  });
</script>
</html>
