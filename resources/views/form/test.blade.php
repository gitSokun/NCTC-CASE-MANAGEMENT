@extends('layouts.master')

@section('title_page')
ផ្ទាំងគ្រប់គ្រង ព្រឹត្តិការណ៍ (NCTC - 2024)
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
@endsection
@section('content')
<div class="container-fluid">
	@foreach($provocative_cases as $case)
	    {{$case}}
	@endforeach
</div><!-- /.container-fluid -->
@endsection
