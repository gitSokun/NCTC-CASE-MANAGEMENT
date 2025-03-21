@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item"><a href="#">គ្រប់គ្រងប្រព័ន្ធ</a></li>
<li class="breadcrumb-item active">បញ្ជីអ្នក​ប្រើប្រាស់</li>
@endsection

@section('sidebar')
@include('sidebar.sidebarUserList')
@endsection

@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
				<!--============== Widgets ================-->
				<div class="col-md-3 col-sm-6 col-12">
					<div class="info-box">
						<span class="info-box-icon bg-info"><i class="far fa-user"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">អ្នកប្រើប្រាស់សរុប</span>
							<span class="info-box-number">300</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-md-3 col-sm-6 col-12">
					<div class="info-box">
						<span class="info-box-icon bg-success"><i class="fas fa-user-plus"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">អ្នកប្រើប្រាស់សកម្មសរុប</span>
							<span class="info-box-number">300</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-md-3 col-sm-6 col-12">
					<div class="info-box">
						<span class="info-box-icon bg-warning"><i class="far fa-user"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">អ្នករាយការណ៍សរុប</span>
							<span class="info-box-number">100</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-md-3 col-sm-6 col-12">
					<div class="info-box">
						<span class="info-box-icon bg-danger"><i class="far fa-user"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">អ្នកប្រើប្រាស់ធម្មតាសរុប</span>
							<span class="info-box-number">200</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!--=======================================-->
			<div class="col-12">

				<div class="card">
					<div class="card-header">
						<button type="button" class="btn btn-primary Battambang"
							onclick="location.href='{{ route('user-create') }}'">
							<i class="nav-icon fas fa-plus" aria-hidden="true"></i>
							បង្កើតអ្នក​ប្រើប្រាស់ថ្មី
						</button>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr class="Battambang">
									<th>លេខសម្គាល់</th>
									<th>ភេទ</th>
									<th>ឈ្មោះ</th>
									<th>ជំនាញ</th>
									<th>ការអប់រំ</th>
									<th>សកម្មភាព</th>
								</tr>
							</thead>
							<tbody>
								@foreach($userProfiles as $userProfile)
								<tr class="Battambang">
									<td>
										<p style="font-weight: 100;">{{$userProfile->id}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">
											@if($userProfile->gender =='M')
											ប្រុស
											@else
											ស្រី
											@endif
										</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$userProfile->first_name}}
											{{ $userProfile->last_name}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$userProfile->skill}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$userProfile->education}}</p>
									</td>
									<td>
										<div class="btn-group" style="float: right;">
											<button type="submit" class="btn btn-warning"
												onclick="location.href='{{ url('/user-edit/' . Crypt::encrypt($userProfile->id).'/edit') }}'">
												<i class="fas fa-edit" aria-hidden="true"></i> កែសម្រួល
											</button>
											<button type="submit" class="btn btn-success"
												onclick="location.href='{{ url('/user-detail/' . Crypt::encrypt($userProfile->id)) }}'">
												<i class="fas fa-eye" aria-hidden="true"></i> មើល
											</button>

										</div>
									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
						{{ $userProfiles->links() }}
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
@endsection