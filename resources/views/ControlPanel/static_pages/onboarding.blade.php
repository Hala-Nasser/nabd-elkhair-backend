@extends('ControlPanel.layouts.layout')

@section('title')
<title>نبض الخير</title>
@stop

@section('css')
<style>
  .content-wrapper,
  .main-footer,
  .main-header {
    transition: margin-left .3s ease-in-out;
    margin-left: 0px;
    z-index: 3000;
  }
</style>
@stop



@section('search')
@stop

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-10">
          <h1></h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card" style="margin-right: 10px; margin-left: 10px">
      <div class="card-header">
        <h3 class="card-title" style="color: black;">شاشة الترحيب الثالثة</h3>
      </div>
      <!-- form start -->
      <form method="post" action="{{ URL('static/store/' . $staticPage->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

          <div class="form-group">
            <label for="exampleInputFile">اسم الصفحة</label>
            <div>
              <input type="text" class="form-control"
              style="width:100%; height:40px; margin-left:15px; margin-right:5px; display:block; padding-right: 10px; padding-left: 10px; pointer-events: none;"
              value="{{$staticPage->name}}">
            </div>
          </div>

          @if( !(empty($errors->get('title'))) )
          <div class="alert alert-custom" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px; color: #99253a;
            background-color: #ffd8df;">
            @foreach ($errors->get('title') as $error)
            <ul>
              <li>
                {{ $error }}
              </li>
            </ul>
            @endforeach
          </div>
          @endif

          <div class="form-group">
            <label for="exampleInputFile">عنوان الصفحة</label>
            <div>
              <input type="text" class="form-control" placeholder="أدخل العنوان" name="title"
              style="width:100%; height:40px; margin-left:15px; margin-right:5px; display:block; padding-right: 10px; padding-left: 10px;"
              value="{{$staticPage->title}}">
            </div>
          </div>

          @if( !(empty($errors->get('content'))) )
          <div class="alert alert-custom" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px; color: #99253a;
            background-color: #ffd8df;">
            @foreach ($errors->get('content') as $error)
            <ul>
              <li>
                {{ $error }}
              </li>
            </ul>
            @endforeach
          </div>
          @endif

          <div class="form-group">
            <label for="exampleInputFile">محتوى الصفحة</label>
            <div>
                <textarea class="form-control" name="content" style="width:100%; height:200px; display:block; padding-right: 10px; padding-left: 10px; margin-left:15px; margin-right:5px;">{{$staticPage->content}}</textarea>
            </div>
          </div>

          @if( !(empty($errors->get('image'))) )
          <div class="alert alert-custom" style="margin-bottom:5px; height:fit-content; padding: 5px; padding-top: 10px; padding-left: 20px; color: #99253a;
            background-color: #ffd8df;">
            @foreach ($errors->get('image') as $error)
            <ul>
              <li>
                {{ $error }}
              </li>
            </ul>
            @endforeach
          </div>
          @endif

          <div class="form-group">
            <label for="image" class="form-label">الصورة</label>

            <input type="file" class="filestyle" onchange="showImage('image','img_thumbnail')"
              data-buttonname="btn-secondary" name="image" id="image" data-buttonbefore="true" value=""
              data-text="تصفح.." tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">

            <div class="bootstrap-filestyle input-group">
              <div name="filedrag" style="position: absolute; width: 100%; height: 38.0312px; z-index: -1;">
              </div>
              <span class="group-span-filestyle input-group-btn" tabindex="0">
                <label for="image"
                  style="margin-bottom: 0px; border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;"
                  class="btn btn-secondary ">
                  <span class="buttonText">تصفح..</span>
                </label>
              </span>
              <input type="text" class="form-control " placeholder="لم يتم اختيار صورة بعد" disabled="">
            </div>
            <div class="" {{$staticPage->image == null ? "hidden" : ""}} id="img_thumbnail_show" style="margin-top: 15px">
              <img id="img_thumbnail" class="img_thumbnail" alt="200x200" style="width: 200px; height: 200px;"
                src="{{asset('storage/uploads/images/'.$staticPage->image)}}" data-holder-rendered="true">
            </div>
          </div>
          <!-- /.card-body -->

          <button type="submit" class="btn btn-primary">حفظ</button>

      </form>

    </div>
    <!-- /.card-body -->
    <!-- /.card-body -->
</div>
<!-- /.card -->

</section>
<!-- /.content -->

</div>
<!-- /.content-wrapper -->

@stop

@section('js')
<script>
  function showImage(id_input,id_show_image = 'show_image'){

document.getElementById(id_show_image+'_show').hidden = false;

const imagefile = document.querySelector('#'+id_input);

console.log( imagefile.files[0]);
var reader = new FileReader();
reader.onload = function(e) {
$('#'+id_show_image).attr('src', e.target.result);
};
reader.readAsDataURL(imagefile.files[0]);
}
</script>
@stop