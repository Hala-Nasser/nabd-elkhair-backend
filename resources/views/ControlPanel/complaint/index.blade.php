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
              <th style="width: 1%; text-align:center">
                #
              </th>
              <th style="width: 20%; text-align:center">
                المشتكي
              </th>
              <th style="width: 20%; text-align:center">
                المشتكى عليه
              </th>
              <th style="width: 20%; text-align:center">
                نوع المشتكي
              </th>
              <th style="width: 20%; text-align:center">
                سبب الشكوى
              </th>
              <th style="width: 20%; text-align:center">
                الاجراءات
              </th>
            </tr>
          </thead>
          <tbody>

            @foreach($complaints as $complaint)
            <tr>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $complaint->id }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $complaint->complainer_name }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $complaint->defendant_name }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $complaint->complainer_type }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $complaint->complaint_reason }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                @if ($complaint->complainer_type == "charity")
                    <form action="{{ URL('donor/disable/' . $complaint->defendant_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="margin-bottom:20px; margin-right:20px">تعطيل</button>
                    </form>
                    @else
                    <form action="{{ URL('charity/disable/' . $complaint->defendant_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="margin-bottom:20px; margin-right:20px">تعطيل</button>
                    </form>
                    @endif
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