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
						<button type="button" class="btn btn-primary Battambang"
						onclick="window.location='{{ route('case-information-create')}}'"><i class="nav-icon fas fa-plus"
								aria-hidden="true"></i>
							បង្កើតព្រឹត្តិការណ៍ </button>
						

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
									<th style="width: 20%;">សកម្មភាព</th>
								</tr>
							</thead>
							<tbody>
							@foreach($cases as $case)

								<tr class="Battambang">
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
									
									<td>
										<div class="btn-group" style="float: right;">
											<button type="submit" class="btn btn-warning"
											onclick="location.href='{{ url('/case-information/' . Crypt::encrypt($case->id).'/edit') }}'">
												<i class="fas fa-edit" aria-hidden="true"></i> កែសម្រួល
											</button>
											<button type="submit" class="btn btn-success"
											onclick="location.href='{{ url('/case-information-show/' . Crypt::encrypt($case->id)) }}'">
												<i class="fas fa-eye" aria-hidden="true"></i> មើល
											</button>
										</div>
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