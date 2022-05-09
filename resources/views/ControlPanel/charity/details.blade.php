@extends('ControlPanel.layouts.layout')

@section('title')
<title>{{$charity->name}}</title>
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
          <h1>الجمعيات</h1>
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
        <h3 class="card-title">{{ $charity->name }}</h3>
      </div>
      <!-- form start -->
      <div class="card-body">
        <div class="form-group">
          <label>البريد الالكتروني</label>
          <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $charity->email }}"
            style="pointer-events: none;">
        </div>

        <div class="form-group">
          <label>العنوان</label>
          <input type="text" class="form-control" placeholder="Enter address" name="address"
            value="{{ $charity->address }}" style="pointer-events: none;">
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">رقم الهاتف</label>
          <input type="phone" class="form-control" placeholder="Enter phone number" name="phone"
            value="{{ $charity->phone }}" style="pointer-events: none;">
        </div>

        <div class="form-group">
          <label for="exampleSelectBorder">عن الجمعية</label>
          <div class="form-group"
            style=" border: 1px solid #ced4da; border-radius: 0.25rem; padding-right:10px; padding-top: 5px">
            <p style="pointer-events: none;">
              {{ $charity->about }}
            </p>
          </div>
        </div>

        @if($charity->payment_links != null && !empty($charity->payment_links))
        
        @if ($charity->payment_links->paypal_link != null)
        <div class="form-group">
          <label for="exampleSelectBorder">رابط الباي بال</label>
          <input type="url" class="form-control" placeholder="Enter paypal link" name="paypal"
            value="{{ $charity->payment_links->paypal_link}}" style="pointer-events: none;">
        </div>
        @endif

        @if ($charity->payment_links->visa_link != null)
        <div class="form-group">
          <label for="exampleSelectBorder">رابط الفيزا</label>
          <input type="url" class="form-control" placeholder="Enter visa link" name="visa"
            value="{{ $charity->payment_links->visa_link}}" style="pointer-events: none;">
        </div>
        @endif

        
        @if ($charity->payment_links->creditcard_link != null)
        <div class="form-group">
          <label for="exampleSelectBorder">رابط الكريديت كارد</label>
          <input type="url" class="form-control" placeholder="Enter credit card link" name="credit"
            value="{{ $charity->payment_links->creditcard_link}}" style="pointer-events: none;">
        </div>
        @endif
        @endif



        <div class="form-group">
          <label for="exampleInputPassword1">مفتوح من</label>
          <input type="phone" class="form-control" placeholder="Enter phone number" name="phone"
            value="{{ $charity->open_time }}" style="pointer-events: none;">
        </div>

      </div>

      @if ($charity->activation_status == 1)
      <form action="{{ URL('charity/disable/' . $charity->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger" style="margin-bottom:20px; margin-right:20px">تعطيل</button>
      </form>
      @else
      <form action="{{ URL('charity/enable/' . $charity->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-info" style="margin-bottom:20px; margin-right:20px">تفعيل</button>
      </form>
      @endif

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