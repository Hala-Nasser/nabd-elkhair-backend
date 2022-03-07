@extends('ControlPanel.layouts.layout')

@section('title')
<title>نبض الخير</title>
@stop

@section('css')
<style>
  .content-wrapper, .main-footer, .main-header {
      transition: margin-left .3s ease-in-out;
      margin-left: 0px;
      z-index: 3000;
  }
  </style>
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
            <h1></h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
  
      <!-- Default box -->
      <div class="card" style="margin-right: 10px; margin-left: 10px">
        <div class="card-header">
          <h3 class="card-title"  style="color: black;">نوع تبرع جديد</h3>
        </div>
        <!-- form start -->
        <!-- form start -->
        <form method="post" action="{{ URL('donationtype/store') }}" enctype="multipart/form-data">
          @csrf
          <div class="card-body">

            @if( !(empty($errors->get('image'))) )
            <div class="alert alert-custom" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px; color: #99253a;
            background-color: #ffd8df;">
              @foreach ($errors->get('image') as $error)
              <ul>
                  <li>
                      {{ $error }}
                  </li>
              </ul>
              @endforeach
            </div>
            @endif

            <div class="form-group">
              <label for="exampleInputFile">اختر الصورة</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="image">
                  <label class="custom-file-label" for="exampleInputFile">Choose image</label>
                </div>
              </div>
            </div>
          <!-- /.card-body -->

            <button type="submit" class="btn btn-primary">إضافة</button>
          
        </form>

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