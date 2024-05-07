@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">បង្កើតព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)</li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
@endsection
@section('content')
<div class="container-fluid Battambang">
	<div class="row">
		<!-- /.col -->
		<div class="col-md-9 Battambang">
			<div class="card">
				<div class="card-header p-2">
					<h4 style="font-weight: bold; ">{{$case->title}}</h4>
					<p>ចុះផ្សាយថ្ងៃទី{{$case->releaseDay}} ខែ{{$case->releaseMonth}} ឆ្នាំ{{$case->releaseYear}}</p>
					<p>{{$case->case_number}}</p>
				</div><!-- /.card-header -->
				<div class="card-body">
					<!--<img class="img-fluid pad" src="{{asset('dist/img/news/ISIS5.jpg')}}" alt="Photo">-->
					<p style="">
						{!!$case->description!!}
					</p>

				</div><!-- /.card-body -->
			</div>
			<div class="card">
				<div class="card-header p-2">
					<h4 style="font-weight: bold; ">បញ្ជីឯកសារ</h4>
				</div><!-- /.card-header -->
				<div class="card-body">

					<table border="1" style="width:100%" ;>
						<tr>
							<th style="width:10%">ឯកសារ</th>
							<th>ឈ្មោះ</th>
							<th style="width:20%"> សកម្មភាព</th>
						</tr>
						@foreach($caseUploads as $file)
						<tr>
							<td>
								<div style="height: 61px; line-height: 61px; text-align: center;">
									<span style="display: inline-block; vertical-align: middle; line-height: normal;"
										class="info-box-icon bg-besic">
										<i class="far fa-file fa-3x"></i>
									</span>

								</div>
							</td>
							<td>{{$file->file_name}}</td>
							<td>
								<a class="btn btn-info" href="{{url('/download/'.$file->id)}}"><i
										class="fas fa-download" aria-hidden="true"></i>ទាញយកឯកសារ</a>

							</td>
						</tr>
						@endforeach

					</table>
				</div><!-- /.card-body -->
			</div>


			<!-- /.card -->
		</div>
		<div class="col-md-3">

			<!-- Profile Image -->


			<!-- About Me Box -->
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">ព័ត៌មានដូចគ្នា/ព័ត៌មានតែមួយ</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					@foreach($relatedCases as $relatedCase)
					<a href="{{ url('/case-information-show/' . Crypt::encrypt($relatedCase->id)) }}">

						<strong><i class="fas fa-book mr-1"></i> {{$relatedCase->title}}</strong>
						<div class="mb-0 str_limit_body" style="width: 100%; word-wrap: break-word;">
							{{strip_tags($relatedCase->description)}}</div>
					</a>
					<p>{{$relatedCase->case_number}}</p>
					<hr>

					@endforeach

				</div>
				<!-- /.card-body -->
			</div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">ព័ត៌មានចុងក្រោយ</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					@foreach($latestCases as $latestCase)
					<a href="{{ url('/case-information-show/' . Crypt::encrypt($latestCase->id)) }}">

						<strong><i class="fas fa-book mr-1"></i> {{$latestCase->title}}</strong>
						<div class="mb-0 str_limit_body" style="width: 100%; word-wrap: break-word;">
							{{strip_tags($latestCase->description)}}</div>
					</a>
					<p>{{$latestCase->case_number}}</p>
					<hr>

					@endforeach

				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>

	</div>
</div>
@endsection