@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">លុបព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)</li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
@endsection
@section('content')
<div class="container-fluid Battambang">
	<div class="row">
		<form class="form-horizontal" enctype="multipart/form-data" id="newcase" method="POST"
			action="{{ route('case-information-delete-info') }}">
			{{ csrf_field() }}
			<input class="form-control " id="id" name="id" value="{{$case->id}}" placeholder="" hidden>

			<div class="col-md-12">
				<div class="btn-group" style="float: right;">
					<button type="button" class="btn btn-warning" onclick="window.location='{{ route('CaseList')}}'">
						<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
					</button>
					<button type="submit" class="btn btn-danger toastrDefaultSuccess">
						<i class="fas fa-trash" aria-hidden="true"></i> លុប
					</button>
				</div>
			</div>
		</form>
		<div class="col-md-12">

			<div class="card card-primary card-outline card-tabs">

				<div class="card-header p-0 pt-1 border-bottom-0">
					<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">

						<li class="nav-item">
							<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
								href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
								aria-selected="true">ខ្លឹមសារជាភាសាខ្មែរ</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
								href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile"
								aria-selected="false">ខ្លឹមសារដើម</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill"
								href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages"
								aria-selected="false">បញ្ជីឯកសារ</a>
						</li>
					</ul>

				</div>
				<div class="card-body">

					<div class="tab-content" id="custom-tabs-three-tabContent">

						@if($caseKH)
						<div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
							aria-labelledby="custom-tabs-three-home-tab">
							<div class="card">

								<div class="card-header p-2">
									<h5 style="font-weight: bold; ">{{$caseKH->title}}</h5>
									<p>ចុះផ្សាយថ្ងៃទី{{$caseKH->releaseDay}} ខែ{{$caseKH->releaseMonth}}
										ឆ្នាំ{{$caseKH->releaseYear}}</p>
									<p>{{$caseKH->case_number}}</p>
								</div><!-- /.card-header -->
								<div class="card-body">
									<!--<img class="img-fluid pad" src="{{asset('dist/img/news/ISIS5.jpg')}}" alt="Photo">-->
									<p style="">
										{!!$caseKH->description!!}
									</p>

								</div><!-- /.card-body -->
							</div>
						</div>
						@else
						<div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
							aria-labelledby="custom-tabs-three-home-tab">
							<div class="card">

								<div class="card-header p-2">
									<h5 style="font-weight: bold; ">បកប្រែភាសាខ្មែរ</h5>

								</div><!-- /.card-header -->
								<div class="card-body">
									<!--<img class="img-fluid pad" src="{{asset('dist/img/news/ISIS5.jpg')}}" alt="Photo">-->
									<p style="">
										មិនបាន បកប្រែភាសាខ្មែរ
									</p>

								</div><!-- /.card-body -->
							</div>
						</div>
						@endif


						<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
							aria-labelledby="custom-tabs-three-profile-tab">
							<div class="card">

								<div class="card-header p-2">
									<h5 style="font-weight: bold; ">{{$case->title}}</h5>
									<p>ចុះផ្សាយថ្ងៃទី{{$case->releaseDay}} ខែ{{$case->releaseMonth}}
										ឆ្នាំ{{$case->releaseYear}}</p>
									<p>{{$case->case_number}}</p>
								</div><!-- /.card-header -->
								<div class="card-body">
									<!--<img class="img-fluid pad" src="{{asset('dist/img/news/ISIS5.jpg')}}" alt="Photo">-->
									<p style="">
										{!!$case->description!!}
									</p>

								</div><!-- /.card-body -->
							</div>
						</div>
						<div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel"
							aria-labelledby="custom-tabs-three-messages-tab">
							<div class="card">

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
													<span
														style="display: inline-block; vertical-align: middle; line-height: normal;"
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
						</div>

					</div>
				</div>
				<!-- /.card -->
			</div>
		</div>

	</div>
</div>
@endsection