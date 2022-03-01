@extends('dashboard.layouts.layout')
@section('title')
<title>Happy Shopping | Store</title>
@stop

@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
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
          <h1>Stores</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Stores</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
          <thead>
            <tr>
              <th style="width: 1%">
                #
              </th>
              <th style="width: 15%">
                Name
              </th>
              <th style="width: 15%">
                Image
              </th>
              <th style="width: 17%">
                Address
              </th>
              <th style="width: 15%">
                Phone
              </th>
              <th style="width: 15%">
                Category Name
              </th>
              <th style="width: 20%">
              </th>
            </tr>
          </thead>
          <tbody>

           @foreach($stores as $store)
         <tr>
                      <td>
                          #
                      </td>
                      <td>
                          <h4>
                              {{ $store->name }}
                          </h4>
                          
                      </td>
                      <td>
                        <img alt="Avatar" class="table-avatar" src="{{asset('storage/uploads/images/'.$store->image)}}"  style="width:100px; height:80px; border-radius: 8px; object-fit: cover;">    
                      </td>

                      <td style="margin-right: 10px;">
                          <h5 >
                              {{ $store->address }}
                          </h5>
                          
                      </td>

                      <td>
                          <h5>
                              {{ $store->phone }}
                          </h5>
                          
                      </td>
                      <td>
                          <h5>
                      @foreach ($categories as $category)

                      @if($category->id == $store->category_id)
                      {{ $category->name }}
                      @endif
                      
                      @endforeach
                              
                          </h5>
                          
                      </td>
                    
                      <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ URL('store/' . $store->id . '/edit') }}">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                        </a>
                        <form action="{{ URL('store/delete/' . $store->id) }}" method="POST" style="display: inline;">
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


       @section('js')
       <!-- jQuery -->
       <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
       <!-- Bootstrap 4 -->
       <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
       <!-- AdminLTE App -->
       <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
       <!-- AdminLTE for demo purposes -->
       <script src="{{ asset('dist/js/demo.js') }}"></script>
       @stop