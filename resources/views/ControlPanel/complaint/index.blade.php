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
                نوع المشتكي
              </th>
              <th style="width: 20%">
                سبب الشكوى
              </th>
            </tr>
          </thead>
          <tbody>

            @foreach($complaints as $complaint)
            <tr>
              <td style="vertical-align: middle;">
                <h6>{{ $complaint->id }}</h6>
              </td>
              <td style="vertical-align: middle;">
                <h6>{{ $complaint->complainer_id }}</h6>
              </td>
              <td style="vertical-align: middle;">
                <h6>{{ $complaint->defendant_id }}</h6>
              </td>
              <td style="vertical-align: middle;">
                <h6>{{ $complaint->complainer_type }}</h6>
              </td>
              <td style="vertical-align: middle;">
                <h6>{{ $complaint->complaint_reason }}</h6>
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