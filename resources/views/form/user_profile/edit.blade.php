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
			<form class="form-horizontal" id="newStaff" method="POST" action="{{ route('user-update') }}">
				{{ csrf_field() }}
				<input class="form-control " id="id" name="id" value="{{$userProfile->id}}" placeholder="" hidden>
				<div class="card">
					<div class="card-header">
						<div class=" Battambang">
							<div class="row">
								<div class="col-sm-6">
									<h4>ចុះឈ្មោះអ្នក​ប្រើប្រាស់</h4>
								</div>
								<div class="col-sm-6">
									<div class="btn-group" style="float: right;">
										<button type="button" class="btn btn-danger"
											onclick="window.location='{{ route('user-list')}}'">
											<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
										</button>
										<button type="submit" class="btn btn-success">
											<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុក
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

								<select class="custom-select rounded-1" id="gender" name="gender">
									<option value="M" {{$userProfile->gender == 'M'  ? 'selected' : ''}}>ប្រុស</option>
									<option value="F" {{$userProfile->gender == 'F' ? 'selected' : ''}}>ស្រី</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputName" class="col-sm-2 col-form-label" style="color:red">* នាមត្រកូល</label>
							<div class="col-sm-10">
								<input class="form-control @error('first_name') is-invalid @enderror" id="first_name"
									name="first_name" value="{{$userProfile->first_name}}" placeholder="នាមត្រកូល">
								@if($errors->has('first_name'))
								<label for="inputSkills" class="col-sm-12 col-form-label "
									style="color:red;">{{ $errors->first('first_name') }}</label>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" style="color:red">* ឈ្មោះ</label>
							<div class="col-sm-10">
								<input type="text" class="form-control @error('last_name') is-invalid @enderror"
									id="last_name" name="last_name" value="{{$userProfile->last_name}}"
									placeholder="ឈ្មោះ">
								@if($errors->has('last_name'))
								<label for="inputSkills" class="col-sm-12 col-form-label "
									style="color:red;">{{ $errors->first('last_name') }}</label>
								@endif
							</div>
						</div>


						<div class="form-group row">
							<label for="inputSkills" class="col-sm-2 col-form-label">ជំនាញ</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="skill" name="skill"
									placeholder="ជំនាញ">{{$userProfile->skill}}</textarea>
								@if($errors->has('skill'))
								<label for="inputSkills" class="col-sm-12 col-form-label "
									style="color:red;">{{ $errors->first('skill') }}</label>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="inputSkills" class="col-sm-2 col-form-label">ការអប់រំ</label>
							<div class="col-sm-10">
								<textarea style="height: 120px;" class="form-control" id="education" name="education"
									placeholder="ការអប់រំ">{{$userProfile->education}}</textarea>
								@if($errors->has('education'))
								<label for="inputSkills" class="col-sm-12 col-form-label "
									style="color:red;">{{ $errors->first('education') }}</label>
								@endif

							</div>
						</div>
						<div class="form-group row">
							<label for="inputExperience" class="col-sm-2 col-form-label">កំណត់ចំណាំ</label>
							<div class="col-sm-10">
								<textarea style="height: 140px;" class="form-control" id="remark" name="remark"
									placeholder="កំណត់ចំណាំ">{{$userProfile->remark}}</textarea>
								@if($errors->has('remark'))
								<label for="inputSkills" class="col-sm-12 col-form-label "
									style="color:red;">{{ $errors->first('remark') }}</label>
								@endif
							</div>
						</div>

					</div><!-- /.card-body -->
					<!--=============================== Authentication ===========================-->
					<div class="card-header">
						<div class=" Battambang">
							<div class="row">
								<div class="col-sm-6">
									<h4>ព័ត៌មានសម្ងាត់</h4>
								</div>
								
							</div>

						</div>
					</div>
					<div class="card-body">
						<div class="form-group row">
							<div class="col-sm-2"></div>
							<div class="col-sm-10 row custom-control custom-checkbox">
								<input class="custom-control-input" type="checkbox" id="status" value="checked"
									checked>
								<label for="status"
									class="custom-control-label">អនុញ្ញាតឱ្យអ្នកប្រើប្រើប្រព័ន្ធ (Active / inactive)</label>
							</div>
						</div>
						<div class="form-group row">
							<label for="inputName2" class="col-sm-2 col-form-label" style="color:red">* Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control @error('password') is-invalid @enderror"
									id="password" name="password" value="" placeholder="**********">
								@if($errors->has('password'))
								<label for="inputSkills" class="col-sm-12 col-form-label "
									style="color:red;">{{ $errors->first('password') }}</label>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<label for="inputName2" class="col-sm-2 col-form-label" style="color:red">* Role</label>
							<div class="col-sm-10">
								<select class="custom-select rounded-1" id="role" name="role">
								   <option value="empty"></option>
									<option value="ADMIN">ADMIN</option>
									<option value="REPORTER">REPORTER</option>
									<option value="USER">USER</option>
								</select>
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

						@if($userProfile->file_path)
						<img class="profile-user-img img-fluid img-circle"
							src="{{asset('avatar/'.$userProfile->file_path)}}" alt="User profile picture">
						@else
						<img class="profile-user-img img-fluid img-circle" src="{{asset('dist/img/default-150x150.png')}}"
							alt="User profile picture">
						@endif

					</div>
					<form class="form-horizontal" enctype="multipart/form-data" id="updateMyProfile" method="POST"
						action="{{ route('upload-my-profile') }}">
						{{ csrf_field() }}
						<input class="form-control " id="profile_id" name="profile_id" value="{{$userProfile->id}}"
							placeholder="" hidden>
						<!--<div style="padding-top: 3%;">
							<input type="file" class="form-control" name="profile_image" id="profile_image"
								style="padding-top: 1%;padding-left: 1%;" accept="image/png, image/gif, image/jpeg" />
						</div>-->
						<!--<div class="text-center" style="padding-top: 3%;">
							<button type="submit" class="btn btn-primary">
								<i class="fas fa-upload" aria-hidden="true"></i> បង្ហោះរូបភាព
							</button>
						</div>-->
					</form>
					<h3 class="profile-username text-center">{{$userProfile->first_name}} {{$userProfile->last_name}}
					</h3>

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
						{{$userProfile->education}}
					</p>

					<hr>

					<strong><i class="fas fa-map-marker-alt mr-1"></i> ទីតាំង/Location</strong>

					<p class="text-muted">
						{{$userProfile->skill}}
					</p>

					<hr>

					<strong><i class="far fa-file-alt mr-1"></i> កំណត់ចំណាំ/Notes</strong>

					<p class="text-muted">
						{{$userProfile->remark}}
					</p>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
	</div>
</div>
@endsection