@extends('dashboard.layouts.layout')
@section('title')
<title>Happy Shopping | Edit store</title>
@stop

@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css ') }}">
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
          <h1>Edit store</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-11">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ URL('store/update/' . $store->id) }}" enctype="multipart/form-data">
              @csrf
              <div class="card-body">

                <div style="display: inline;">
                 <img src="{{asset('storage/uploads/images/'.$store->image)}}" alt="{{$store->name}}" style="float: left; width: 30%;  border-radius: 8px; object-fit: cover; height:300px;" id="img">
               </div>

               <div style="float: right; width: 67%; ">
                @if( !(empty($errors->get('name'))) )
                <div class="alert alert-danger" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px;">
                  @foreach ($errors->get('name') as $error)
                  <h6>!    {{ $error }}</h6>
                  @endforeach
                </div>
                @endif

                <div class="form-group">
                  <label >Store name</label>
                  <input type="text" class="form-control" placeholder="Enter name" name="name" value="{{ $store->name }}">
                </div>


                @if( !(empty($errors->get('address'))) )
                <div class="alert alert-danger" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px;">
                  @foreach ($errors->get('address') as $error)
                  <h6>!    {{ $error }}</h6>
                  @endforeach
                </div>
                @endif

                <div class="form-group">
                  <label >Store address</label>
                  <input type="text" class="form-control" placeholder="Enter address" name="address" value="{{ $store->address }}">
                </div>


                @if( !(empty($errors->get('phone'))) )
                <div class="alert alert-danger" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px;">
                  @foreach ($errors->get('phone') as $error)
                  <h6>!    {{ $error }}</h6>
                  @endforeach
                </div>
                @endif

                <div class="form-group">
                  <label for="exampleInputPassword1">Phone number</label>
                  <input type="phone" class="form-control" placeholder="Enter phone number" name="phone" value="{{ $store->phone }}">
                </div>

                <div class="form-group">
                  <label for="exampleSelectBorder">Store category</label>
                  <!-- select -->
                  <div class="form-group">
                    <select name="category_id" class="form-control">

                      @foreach ($categories as $category)
                      @if ($category->id == $store->category_id)
                  <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                @else
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endif
                      @endforeach
                    </select>

                  </div>
                </div>

                @if( !(empty($errors->get('image'))) )
                <div class="alert alert-danger" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px;">
                  @foreach ($errors->get('image') as $error)
                  <h6>!    {{ $error }}</h6>
                  @endforeach
                </div>
                @endif


                <div class="form-group">
                  <label for="exampleInputFile">Store image</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="image" id="inputFile">
                      <label class="custom-file-label" for="exampleInputFile">Choose image</label>
                    </div>
                  </div>
                </div>
               </div>

                

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@stop


@section('js')
<!-- jQuery -->

<!-- jQuery -->
<script src=" {{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src=" {{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE App -->
<script src=" {{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    bsCustomFileInput.init();
  });

  const inputFile = document.getElementById("inputFile");
  const img = document.getElementById("img");

  inputFile.addEventListener("change", function (){
    const file = this.files[0];
    console.log(file);
    if (file){
      const reader = new FileReader();
      reader.addEventListener("load", function () {
        img.setAttribute("src", this.result);
      });
      reader.readAsDataURL(file);
    }else{
       img.setAttribute("src", "{{asset('storage/uploads/images/'.$store->image)}}");
    }
  });
</script>


@stop
