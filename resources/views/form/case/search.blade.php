@extends('layouts.master')
@section('sidebar')
@include('sidebar.dashboard-side')
@endsection
@section('content')
<div class="container-fluid Battambang">
	<!-- Content Header (Page header) -->
	<section class="content-header ">
		<div class="container-fluid">
			<h5 class="text-center">ស្វែងរកព្រឹត្តិការណ៍</h5>
		</div>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<form method="POST" action="{{ route('search-result-case-information') }}">
						{{ csrf_field() }}
						<div class="input-group input-group-lg">
							<input type="search" name="search" id="search" class="form-control form-control-lg"
								placeholder="ព្រឹត្តិការណ៍" value="{{$search}}">
							<div class="input-group-append">
								<button type="submit" class="btn btn-lg btn-default">
									<i class="fa fa-search"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-md-10 offset-md-1">
					<div class="list-group">
						<div class="list-group-item">
							<div class="row">
								<div class="col px-4">
									<div>
										<h5>ស្វែងរកព្រឹត្តិការណ៍ ប្រចាំថ្ងៃ</h5>
										<p class="mb-0"></p>
									</div>
								</div>
							</div>
						</div>
						@foreach($cases as $case)
						<div class="list-group-item">
							<div class="ribbon-wrapper">
								@if($case->case_id_kh)
								<div class="ribbon bg-primary">បកប្រែ</div>
								@else
								<div class="ribbon bg-warning"></div>
								@endif

							</div>
							<a href="{{ url('/case-information-show/' . Crypt::encrypt($case->id)) }}">
								<div class="row">
									<div class="col-auto">
										<img class="img-fluid" src="{{asset('dist/img/default-150x150.png')}}" alt="Photo"
											style="max-height: 100px;">
									</div>
									<div class="col px-4">
										<div>
											<div class="float-right" style="color: darkblue;">{{$case->released_date}}
											</div>
											<h5 class="str_limit_title"><a
													href="{{ url('/case-information-show/' . Crypt::encrypt($case->id)) }}">{{$case->title}}</a>
											</h5>
											<h6 class="str_limit_title"><a
													href="{{ url('/case-information-show/' . Crypt::encrypt($case->id)) }}">{{$case->case_number}}</a>
											</h6>
											<div class="mb-0 str_limit_body">{{strip_tags($case->description)}}</div>
										</div>
									</div>
								</div>
							</a>
						</div>

						@endforeach
						<div class="list-group-item">
							<div class="row">
								<div class="col px-4">
									<div class="float-right">
										{{ $cases->links() }}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


	</section>


</div>

@endsection