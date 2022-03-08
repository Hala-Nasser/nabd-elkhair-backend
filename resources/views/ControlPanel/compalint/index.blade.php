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
          <h1>الشكاوي</h1>
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
        <h3 class="card-title">الشكاوي</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th style="width: 1%">
                #
              </th>
              <th style="width: 20%">
                المشتكي
              </th>
              <th style="width: 20%">
                المشتكى عليه
              </th>
              <th style="width: 20%">
                سبب الشكوى
              </th>
            </tr>
          </thead>
          <tbody>

            @foreach($charities as $charity)
            <tr>
              <td>
                <h6>{{ $charity->id }}</h6>
              </td>
              <td>

                <h6>{{ $charity->name }}</h6>

              </td>
              <td>
                <h6>{{ $charity->email }}</h6>
              </td>

              <td>
                <a class="btn btn-info btn-sm" href="{{ URL('charity/' . $charity->id) }}">
                  <i class="fa fa-eye">
                  </i>
                  عرض
                </a>
                <form action="{{ URL('charity/delete/' . $charity->id) }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash">
                    </i>
                    حذف</button>
                </form>
                <a class="btn btn-secondary btn-sm" href="{{ URL('charity/donationtype/' . $charity->id) }}">
                  <i>
                    <img src="{{ asset('donation.png') }}" style="width: 19px; height:19px">
                  </i>
                  عرض التبرعات
                </a>
              </td>
            </tr>
            @endforeach

          </tbody>
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