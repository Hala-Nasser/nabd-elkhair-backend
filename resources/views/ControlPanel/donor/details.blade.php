@extends('ControlPanel.layouts.layout')

@section('title')
<title>{{$donor->name}}</title>
@stop

@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
  .content-wrapper,
  .main-footer,
  .main-header {
    transition: margin-left .3s ease-in-out;
    margin-left: 0px;
    z-index: 3000;
  }
</style>

@stop



@section('search')
@stop

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>تفاصيل المتبرع</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card" style="margin-right: 10px; margin-left: 10px">
      <div class="card-header">


        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
        <h3 class="card-title">{{ $donor->name }}</h3>
      </div>
      <!-- form start -->
      <div class="card-body">

        <div class="row" style="margin-left: 10px; margin-right:10px">
          <div class="column" style="width: 60%; float: right;">
            <div class="form-group">
              <label>البريد الالكتروني</label>
              <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $donor->email }}"
                style="pointer-events: none;">
            </div>
    
            <div class="form-group">
              <label>العنوان</label>
              <input type="text" class="form-control" placeholder="Enter address" name="address"
                value="{{ $donor->location }}" style="pointer-events: none;">
            </div>
    
            <div class="form-group">
              <label for="exampleInputPassword1">رقم الهاتف</label>
              <input type="phone" class="form-control" placeholder="Enter phone number" name="phone"
                value="{{ $donor->phone }}" style="pointer-events: none;">
            </div>

            @if ($donor->activation_status == 1)
          <form action="{{ URL('donor/disable/' . $donor->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger" style="margin-bottom:20px;">تعطيل</button>
          </form>
          @else
          <form action="{{ URL('donor/enable/' . $donor->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-info" style="margin-bottom:20px;">تفعيل</button>
          </form>
          @endif
    
          </div>
    
          <div class="column" style="width: 10%;">
        </div>

          <div class="column" style="width: 30%; float: right; margin_right:5px;">
            <img src="{{asset('storage/uploads/images/'.$donor->image)}}" alt="{{$donor->name}}" style="width: 100%;  border-radius: 8px; object-fit: cover; height:300px;" id="img">
        </div>
        
          </div>

    </div>
    <!-- /.card-body -->
    <!-- /.card-body -->
</div>
<!-- /.card -->

</section>
<!-- /.content -->

</div>
<!-- /.content-wrapper -->

@stop