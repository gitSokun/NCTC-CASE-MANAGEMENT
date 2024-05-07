@extends('layouts.master')

@section('title_page')
បង្កើតព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">បង្កើតព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)</li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">

		</div>
		<!-- /.col-md-6 -->
		<div class="col-lg-6">

		</div>
		<!-- /.col-md-6 -->
	</div>
	<!-- /.row -->
</div>
@endsection