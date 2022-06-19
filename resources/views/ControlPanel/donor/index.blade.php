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
          <h1>المتبرعين</h1>
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
        <h3 class="card-title">المتبرعين</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th style="width: 1%; text-align:center">
                #
              </th>
              <th style="width: 20%; text-align:center">
                الاسم
              </th>
              <th style="width: 20%; text-align:center">
                البريد الالكتروني
              </th>
              <th style="width: 20%; text-align:center">
                رقم الهاتف
              </th>
              <th style="width: 40%; text-align:center">
                الاجراءات
              </th>
            </tr>
          </thead>

          @if($donors->isEmpty())
          <tbody>
            <tr>
              <td valign="top" colspan="8" style="text-align: center">لا يوجد متبرعين</td>
            </tr>
          </tbody>
          @else
          <tbody>
            @foreach($donors as $donor)
            <tr>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donor->id }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donor->name }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donor->email }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <h6 style="font-size:14px;">{{ $donor->phone }}</h6>
              </td>
              <td style="vertical-align: middle; text-align:center">
                <a class="btn btn-info btn-sm" href="{{ URL('donor/' . $donor->id) }}">
                  <i class="fa fa-eye">
                  </i>
                  عرض
                </a>
                <form action="{{ URL('donor/delete/' . $donor->id) }}" method="POST" style="display: inline;">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل تريد حذف المتبرع؟')">
                    <i class="fas fa-trash">
                    </i>
                    حذف</button>
                </form>
                <a class="btn btn-secondary btn-sm" href="{{ URL('donor/donation/' . $donor->id) }}">
                  <i>
                    <img src="{{ asset('donation.png') }}" style="width: 19px; height:19px">
                  </i>
                  عرض التبرعات
                </a>
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