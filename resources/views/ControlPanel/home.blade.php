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
          <h1>الجمعيات</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card" style="margin-right: 10px;">
      <div class="card-header">
        

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
        <h3 class="card-title">الجمعيات</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th style="width: 1%">
                #
              </th>
              <th style="width: 20%">
                الاسم
              </th>
              <th style="width: 20%">
                البريد الالكتروني
              </th>
              <th style="width: 20%">
                الاجراءات
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
                <a class="btn btn-info btn-sm" href="{{ URL('category/' . $charity->id . '/edit') }}">
                  <i class="fas fa-pencil-alt">
                  </i>
                  Edit
                </a>
                <form action="{{ URL('category/delete/' . $charity->id) }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash">
                    </i>
                    Delete</button>
                </form>
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