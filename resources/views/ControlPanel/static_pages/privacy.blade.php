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
          <h3 class="card-title"  style="color: black;">سياسة الاستخدام</h3>
        </div>
        <!-- form start -->
        <form method="post" action="{{ URL('privacy/store') }}" enctype="multipart/form-data">
          @csrf
          <div class="card-body">

            @if( !(empty($errors->get('name'))) )
            <div class="alert alert-custom" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px; color: #99253a;
            background-color: #ffd8df;">
              @foreach ($errors->get('name') as $error)
              <ul>
                  <li>
                      {{ $error }}
                  </li>
              </ul>
              @endforeach
            </div>
            @endif

            <div class="form-group">
              <label for="exampleInputFile">عنوان الصفحة</label>
              <div>
                  <input name="name" style="width:90%; height:50px; margin-left:auto; margin-right:auto; display:block; pointer-events: none; padding-right: 10px;" type="text" value="سياسة الاستخدام">
              </div>
            </div>


            @if( !(empty($errors->get('content'))) )
            <div class="alert alert-custom" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px; color: #99253a;
            background-color: #ffd8df;">
              @foreach ($errors->get('content') as $error)
              <ul>
                  <li>
                      {{ $error }}
                  </li>
              </ul>
              @endforeach
            </div>
            @endif

            <div class="form-group">
              <label for="exampleInputFile">محتوى الصفحة</label>
              <div>
                  <textarea name="content" style="width:90%; height:200px; margin-left:auto; margin-right:auto; display:block; padding-right: 10px; padding-left: 10px;">{{$privacy->content}}</textarea>
              </div>
            </div>
          <!-- /.card-body -->

            <button type="submit" class="btn btn-primary">حفظ</button>
          
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