@extends('dashboard.layouts.layout')
@section('title')
<title>Happy Shopping | Rate</title>
@stop

@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
<style type="text/css">
.rating-css div {
	color: #ffe400;
	font-size: 30px;
	font-family: sans-serif;
	font-weight: 800;
	text-align: center;
	text-transform: uppercase;
	padding: 0;
}
.rating-css input {
	display: none;
}
.rating-css input + label {
	font-size: 5px;
	size: 10px;
	text-shadow: 1px 1px 0 #8f8420;
	cursor: pointer;
}
.rating-css input:checked + label ~ label {
	color: #b4afaf;
}
.rating-css label:active {
	transform: scale(0.8);
	transition: 0.3s ease;
}
.checked{
	color: #ffd900;
}
</style>
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
					<h1>Rate stores</h1>
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

			<section class="content" style="padding:10px; flex: 1 1 auto;">

				<!-- Default box -->
				<div class="card card-solid" >

					<div class="container-fluid">
						<!-- Small boxes (Stat box) -->
						<div class="row">

							@forelse ($stores as $store)

							<div class="col-lg-3 col-6"  style="padding: 10px;">
								<!-- small box -->
								<div class="small-box bg-info">
									<div class="inner">
										<img alt="Avatar" src="{{asset('storage/uploads/images/'.$store->image)}}"  style="width: 100%; height: 150px; border-radius: 5px; object-fit: cover;">

										<h5 style="margin-left: 5px; margin-top: 10px;">{{ $store->name }}</h5>
									</div>
									<div class="icon">
										<i class="ion ion-bag"></i>
									</div>
									<a  class="small-box-footer">

										<div class="rating">

											@php $final_rate = number_format($store->rating_average) @endphp

											@if($final_rate > 0)

											@for($i =1; $i<= $final_rate; $i++)
											<i class="fa fa-star checked"></i>
											@endfor
											@for($j = $final_rate+1; $j<=5; $j++)
											<i class="fa fa-star"></i>
											@endfor
											<span style="color: #fff; margin-left:10px">{{ $store->rate_num }} ratings</span>

											@else

											<span style="color: #fff;">There is no ratings yet</span>
											
											@endif

										</div>

									</a>
								</div>
							</div>

							@empty

							<h5 style="text-align: center; margin: 20px; width:100%">There is no matches result</h5>

							@endforelse

						</div>
						<!-- /.row -->
					</div><!-- /.container-fluid -->       
				</div>
				<!-- /.card -->

			</section>

			
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



