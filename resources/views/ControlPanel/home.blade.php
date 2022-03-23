@extends('ControlPanel.layouts.layout')

@section('title')
<title>نبض الخير</title>
@stop

@section('css')

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
          <h1>الرئيسية</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card" style="margin-right: 10px; margin-left: 10px">
      <div class="card-header">
        <h3 class="card-title">إحصائيات</h3>
      </div>
      <div class="card-body p-0">
        <div class="row" style="margin: 20px">
            <div class="card" style="background-color: rgba(0,0,0,.03)">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="inner" style="margin-top:15px">
                            <h3 style="color:#000">500</h3>
            
                            <p style="color:#000">عدد المتبرعين</p>
                          </div>
                          <div class="icon">
                            <i>
                                <img src="{{ asset('donor.png') }}" style="width: 50px; height:50px;vertical-align: top; margin-top:30px; filter: invert(48%) sepia(13%) saturate(3207%) hue-rotate(130deg) brightness(95%) contrast(80%);">
                            </i>
                          </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->

            <div class="card" style="background-color: rgba(0,0,0,.03); margin-right:20px">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="inner" style="margin-top:15px">
                            <h3 style="color:#000">20</h3>
            
                            <p style="color:#000">عدد الجمعيات</p>
                          </div>
                          <div class="icon">
                            <i>
                                <img src="{{ asset('charity.png') }}" style="width: 40px; height:50px;vertical-align: top; margin-top:30px; filter: invert(48%) sepia(13%) saturate(3207%) hue-rotate(130deg) brightness(95%) contrast(80%);">
                            </i>
                          </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->

            <div class="card" style="background-color: rgba(0,0,0,.03); margin-right:20px">
                <div class="card-body">
                    <div class="d-flex text-muted">
                        <div class="inner" style="margin-top:15px">
                            <h3 style="color:#000">10</h3>
            
                            <p style="color:#000">عدد الشكاوي</p>
                          </div>
                          <div class="icon">
                            <i>
                                <img src="{{ asset('complaints.png') }}" style="width: 40px; height:40px;vertical-align: top; margin-top:30px; filter: invert(48%) sepia(13%) saturate(3207%) hue-rotate(130deg) brightness(95%) contrast(80%);">
                            </i>
                          </div>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card -->
        </div>
      </div>


      
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->

@stop