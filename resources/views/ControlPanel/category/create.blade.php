@extends('dashboard.layouts.layout')

@section('title')
<title>Happy Shopping | Add Category</title>
@stop

@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css ') }}">
@stop

@section('search')
@stop


@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" >
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-10">
          <h1>Add category</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ URL('category/store') }}" enctype="multipart/form-data">
              @csrf
              <div class="card-body">


                @if( !(empty($errors->get('name'))) )
                <div class="alert alert-danger" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px;">
                  @foreach ($errors->get('name') as $error)
                  <h6>!    {{ $error }}</h6>
                  @endforeach
                </div>
                @endif

                <div class="form-group">
                  <label >Category name</label>
                  <input type="text" class="form-control" placeholder="Enter name" name="name">
                </div>


                @if( !(empty($errors->get('image'))) )
                <div class="alert alert-danger" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px;">
                  @foreach ($errors->get('image') as $error)
                  <h6>!    {{ $error }}</h6>
                  @endforeach
                </div>
                @endif

                <div class="form-group">
                  <label>Category image</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="image">
                      <label class="custom-file-label" for="exampleInputFile">Choose image</label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@stop


@section('js')

<!-- jQuery -->
<script src=" {{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src=" {{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE App -->
<script src=" {{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    bsCustomFileInput.init();
  });
</script>


@stop

