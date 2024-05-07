@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item"><a href="#">គ្រប់គ្រងប្រព័ន្ធ</a></li>
<li class="breadcrumb-item active">ចុះឈ្មោះអ្នក​ប្រើប្រាស់</li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<!-- /.col -->
		<div class="col-md-9">
			<form class="form-horizontal" id="newStaff" method="POST" action="{{ route('user-store') }}">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header">
						<div class=" Battambang">
							<div class="row">
								<div class="col-sm-6">
									<h4>ចុះឈ្មោះអ្នក​ប្រើប្រាស់</h4>
								</div>
								<div class="col-sm-6">
									<div class="btn-group" style="float: right;">
										<button type="button"  class="btn btn-danger"
										onclick="window.location='{{ route('user-list')}}'">
											<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
										</button>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="card-body">

						<div class="form-group row">
							<label class="col-sm-2 col-form-label" style="color:red">* ភេទ</label>
							<div class="col-sm-10">
							
								<select class="custom-select rounded-1" id="gender" name="gender" disabled="true">
									<option value="M" {{$userProfile->gender == 'M'  ? 'selected' : ''}} >ប្រុស</option>
									<option value="F" {{$userProfile->gender == 'F' ? 'selected' : ''}} >ស្រី</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputName" class="col-sm-2 col-form-label" style="color:red">* នាមត្រកូល</label>
							<div class="col-sm-10">
								<input class="form-control @error('first_name') is-invalid @enderror" id="first_name"
									name="first_name" value="{{$userProfile->first_name}}" placeholder="នាមត្រកូល" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" style="color:red">* ឈ្មោះ</label>
							<div class="col-sm-10">
								<input type="text" class="form-control @error('last_name') is-invalid @enderror"
									id="last_name" name="last_name" value="{{$userProfile->last_name}}" placeholder="ឈ្មោះ" readonly>
							</div>
						</div>


						<div class="form-group row">
							<label for="inputSkills" class="col-sm-2 col-form-label">ជំនាញ</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="skill" name="skill" placeholder="ជំនាញ" readonly>{{$userProfile->skill}}</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputSkills" class="col-sm-2 col-form-label">ការអប់រំ</label>
							<div class="col-sm-10">
								<textarea style="height: 120px;" class="form-control" id="education" name="education"
									placeholder="ការអប់រំ" readonly>{{$userProfile->education}}</textarea>

							</div>
						</div>
						<div class="form-group row">
							<label for="inputExperience" class="col-sm-2 col-form-label">កំណត់ចំណាំ</label>
							<div class="col-sm-10">
								<textarea style="height: 140px;" class="form-control" id="remark" name="remark"
									placeholder="កំណត់ចំណាំ" readonly>{{$userProfile->remark}}</textarea>
							</div>
						</div>

					</div><!-- /.card-body -->
				</div>
			</form>
			<!-- /.card -->
		</div>
		<div class="col-md-3">

			<!-- Profile Image -->
			<div class="card card-primary card-outline">
				<div class="card-body box-profile">
					<div class="text-center">
						<img class="profile-user-img img-fluid img-circle" src="../dist/img/user8-128x128.jpg"
							alt="User profile picture">

					</div>

					<h3 class="profile-username text-center">លោក ដារា</h3>

					<p class="text-muted text-center">វិស្វកម្មកម្មវិធី</p>

					<ul class="list-group list-group-unbordered mb-3">
						<li class="list-group-item">
							<b>សមាជិក​ក្រុម៖</b> <a class="float-right">0</a>
						</li>
						<li class="list-group-item">
							<b>ចំនួននៃព្រឹត្តិការណ៍៖</b> <a class="float-right">0</a>
						</li>
						<li class="list-group-item">
							<b>ចំនួន អ្នកគាំទ្រ៖</b> <a class="float-right">0</a>
						</li>
					</ul>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->

			<!-- About Me Box -->
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">ប្រវត្តិរូប​/Profile</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<strong><i class="fas fa-book mr-1"></i> ការអប់រំ/Education</strong>

					<p class="text-muted">

					</p>

					<hr>

					<strong><i class="fas fa-map-marker-alt mr-1"></i> ទីតាំង/Location</strong>

					<p class="text-muted"></p>

					<hr>

					<strong><i class="fas fa-pencil-alt mr-1"></i> ជំនាញ/Skills</strong>

					<p class="text-muted">
						<span class="tag tag-danger"></span>
						<span class="tag tag-success"></span>
						<span class="tag tag-info"></span>
						<span class="tag tag-warning"></span>
						<span class="tag tag-primary"></span>
					</p>

					<hr>

					<strong><i class="far fa-file-alt mr-1"></i> កំណត់ចំណាំ/Notes</strong>

					<p class="text-muted"></p>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
	</div>
</div>
@endsection