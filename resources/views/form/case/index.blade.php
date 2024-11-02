@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="dashboard.html">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">បញ្ជីព្រឹត្តិការណ៍</li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
@endsection
@section('content')
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-2">
								<button type="button" class="btn btn-primary Battambang"
									onclick="window.location='{{ route('case-information-create')}}'"><i
										class="nav-icon fas fa-plus" aria-hidden="true"></i>
									បង្កើតព្រឹត្តិការណ៍ </button>
							</div>
							<div class="col-10">
								<form method="POST" action="{{ route('search-case-index') }}">
									{{ csrf_field() }}
									<div class="input-group input-group-lg">
										<input type="search" name="search" id="search" value="{{$search}}"
											class="form-control form-control-lg" placeholder="ស្វែងរកព្រឹត្តិការណ៍"
											value="">
										<div class="input-group-append">
											<button type="submit" class="btn btn-lg btn-default">
												<i class="fa fa-search"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>



					</div>
					<!-- /.card-header -->
					<div class="card-body">


						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr class="Battambang">
									<th style="width: 15%;">#</th>
									<th>ចំណងជើង</th>
									<th>ប្រទេស</th>
									<th>ខេត្ត</th>
									<th>តំបន់</th>
									<!--<th>បកប្រែ</th>-->
									<th style="width: 40%;">សកម្មភាព</th>
								</tr>
							</thead>
							<tbody>
								@foreach($cases as $case)

								<tr class="Battambang">
									@if($case->case_id_kh)
									<td>
										<p style="font-weight: 100;">{{$case->case_number_kh}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$case->title_kh}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$case->country_kh}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$case->province_city_kh}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$case->area_kh}}</p>
									</td>
									@else
									<td>
										<p style="font-weight: 100;">{{$case->case_number}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$case->title}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$case->country}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$case->province_city}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$case->area}}</p>
									</td>
									@endif
									<td>
										@if($isRoleAdmin)
										<div class="btn-group" style="float: right;">
											<button type="submit" class="btn btn-success"
												onclick="location.href='{{ url('/case-information-show/' . Crypt::encrypt($case->id)) }}'">
												<i class="fas fa-eye" aria-hidden="true"></i> មើល
											</button>
											<button type="submit" class="btn btn-warning" style="width: 135px;"
												onclick="location.href='{{ url('/case-information/' . Crypt::encrypt($case->id).'/edit') }}'">
												<i class="fas fa-edit" aria-hidden="true"></i> កែសម្រួល
											</button>

											@if($case->case_id_kh)
											<button type="submit" class="btn btn-info"
												onclick="location.href='{{ url('/khmer-case-information/' . Crypt::encrypt($case->case_id_kh).'/edit') }}'">
												<i class="fas fa-edit" aria-hidden="true"></i> កែប្រែភាសាខ្មែរ
											</button>
											@else
											<button type="submit" class="btn btn-primary"
												onclick="location.href='{{ url('/case-information/create/khmer/case/' . Crypt::encrypt($case->id)) }}'">
												<i class="fas fa-plus" aria-hidden="true"></i> បកប្រែភាសាខ្មែរ
											</button>
											@endif
											<button type="submit" class="btn btn-danger"
												onclick="location.href='{{ url('/case-information-delete/' . Crypt::encrypt($case->id)) }}'">
												<i class="fas fa-trash" aria-hidden="true"></i> លុប
											</button>
										</div>
										@else
										<div class="btn-group" style="float: right;">

											<button type="submit" class="btn btn-success"
												onclick="location.href='{{ url('/case-information-show/' . Crypt::encrypt($case->id)) }}'">
												<i class="fas fa-eye" aria-hidden="true"></i> មើល
											</button>
											@if($user->id == $case->user_id_created_case)
											<button type="submit" class="btn btn-warning" style="width: 135px;"
												onclick="location.href='{{ url('/case-information/' . Crypt::encrypt($case->id).'/edit') }}'">
												<i class="fas fa-edit" aria-hidden="true"></i> កែសម្រួល
											</button>
											@endif
											@if($user->id == $case->user_id_created_caseKh)
											@if($case->case_id_kh)
											<button type="submit" class="btn btn-info"
												onclick="location.href='{{ url('/khmer-case-information/' . Crypt::encrypt($case->case_id_kh).'/edit') }}'">
												<i class="fas fa-edit" aria-hidden="true"></i> កែប្រែភាសាខ្មែរ
											</button>
											@else
											<button type="submit" class="btn btn-primary"
												onclick="location.href='{{ url('/case-information/create/khmer/case/' . Crypt::encrypt($case->id)) }}'">
												<i class="fas fa-plus" aria-hidden="true"></i> បកប្រែភាសាខ្មែរ
											</button>
											@endif
											<!--<button type="submit" class="btn btn-danger"
													onclick="location.href='{{ url('/case-information-delete/' . Crypt::encrypt($case->id)) }}'">
													<i class="fas fa-trash" aria-hidden="true"></i> លុប
												</button>-->
											@endif

										</div>
										@endif

									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{{ $cases->links() }}
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection