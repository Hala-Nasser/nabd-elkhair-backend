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
          <h1>التبرعات</h1>
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
        <h3 class="card-title">تبرعات {{$donor_name}}</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th style="width: 1%; text-align:center">
                #
              </th>
              <th style="width: 15%; text-align:center">
                الجمعية
              </th>
              <th style="width: 15%; text-align:center">
                اسم الحملة
              </th>
              <th style="width: 10%; text-align:center">
                نوع التبرع
              </th>
              {{-- <th style="width: 10%; text-align:center">
                طريقة التبرع
              </th> --}}
              {{-- <th style="width: 15%; text-align:center">
                رابط التبرع
              </th> --}}
              <th style="width: 15%; text-align:center">
                وصف التبرع
              </th>
              <th style="width: 20%; text-align:center">
            عنوان الاستلام
              </th>
            </tr>
          </thead>


          @if($donations->isEmpty())
          <tbody>
            <tr>
              <td valign="top" colspan="8" style="text-align: center">لا يوجد تبرعات</td>
            </tr>
          </tbody>
          @else
          <tbody>
            @foreach($donations as $donation)
            <tr>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donation->id }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donation->charity_name }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donation->campaign_name }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <img alt="Avatar" src="{{asset('storage/uploads/images/'.$donation->donation_type_image)}}"
                  style="width:50px; height:40px; border-radius: 8px; object-fit: contain;">
              </td>
              {{-- <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donation->donation_way }}</h6>
              </td> --}}
              {{-- <td style="vertical-align: middle; text-align:center">
                @if ($donation->payment_link == null)
                <h6 style="font-size:14px;">-</h6>
                @else
                <h6 style="font-size:14px;">{{ $donation->payment_link }}</h6>
                @endif
              </td> --}}
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donation->description }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donation->donor_district }}-{{ $donation->donor_city }}-{{
                  $donation->donor_address }}</h6>
              </td>
            </tr>
            @endforeach
          </tbody>

          @endif

        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->

@stop