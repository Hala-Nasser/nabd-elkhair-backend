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
                    <h1>أنواع التبرع</h1>
                </div>
            </div>
            <a class="btn btn-info" href="{{ URL('donationtype/create') }}" style="margin-top: 10px">
                نوع تبرع جديد
              </a>
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
                <h3 class="card-title">أنواع التبرع</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 1%; text-align:center">
                                #
                            </th>
                            <th style="width: 20%; text-align:center">
                                الصورة
                            </th>
                            <th style="width: 20%; text-align:center">
                                الاجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($donation_types as $donation_type)
                        <tr>
                            <td style="vertical-align: middle; text-align:center">
                                <h6>{{ $donation_type->id }}</h6>
                            </td>
                            <td style="vertical-align: middle; text-align:center">
                                <img alt="Avatar" src="{{asset('storage/uploads/images/'.$donation_type->image)}}"  style="width:60px; height:40px; border-radius: 8px; object-fit: contain;">
                            </td>

                            <td style="vertical-align: middle; text-align:center">
                                <div class="container">
                                @if ($donation_type->deleted_at == null)
                                <form action="{{ URL('donationtype/delete/' . $donation_type->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </form>
                                @else
                                <form action="{{ URL('donationtype/restore/' . $donation_type->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-info">استرجاع</button>
                                </form>
                                @endif
                                </div>
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