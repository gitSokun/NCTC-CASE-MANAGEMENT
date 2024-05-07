@extends('layouts.master_search')
@section('content')
<div class="container-fluid">
	<div class="row" style="padding-top: 1%;">
		<!-- /.col -->
		<div class="col-md-3">

			<!-- Profile Image -->
			<div class="card card-primary card-outline">
				<div class="card-body box-profile">
					<div class="text-center">
						<img class="profile-user-img img-fluid img-circle"
							src="{{asset('avatar/'.$userProfile->file_path)}}" alt="User profile picture">
					</div>

					<h3 class="profile-username text-center">{{$userProfile->first_name}} {{$userProfile->last_name}}
					</h3>

					<p class="text-muted text-center">{{$userProfile->skill}}</p>

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
		</div>
		<div class="col-md-6">
			<form action="{{ route('update-password') }}" method="POST">
				@csrf

				<div class="card card-primary card-outline">
					<div class="card-header">
						<div class=" Battambang">
							<div class="row">
								<div class="col-sm-6">
									<h4>ផ្លាស់ប្តូរពាក្យសម្ងាត់</h4>
								</div>

							</div>

						</div>
					</div>
					<div class="card-body">
						<!--* alaert sesstion when sucess or error *-->
						@if (session('status'))
						<div class="alert alert-success" role="alert">
							{{ session('status') }}
						</div>
						@elseif (session('error'))
						<div class="alert alert-danger" role="alert">
							{{ session('error') }}
						</div>
						@endif
						<!--* end alaert sesstion when sucess or error *-->
						<div class="form-group row">
							<label for="inputName" class="col-sm-3 col-form-label" style="color:red">*
								លេខសំងាត់​ចាស់</label>
							<div class="col-sm-9">
								<input type="password" class="form-control @error('old_password') is-invalid @enderror"
									id="old_password" name="old_password" placeholder="លេខសំងាត់​ចាស់">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label" style="color:red">* លេខសំងាត់​ថ្មី</label>
							<div class="col-sm-9">
								<input type="password" class="form-control @error('new_password') is-invalid @enderror"
									id="new_password" name="new_password" placeholder="លេខសំងាត់​ថ្មី">
									@error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
							</div>
						</div>
						<div class="form-group row">
							<label for="inputName" class="col-sm-3 col-form-label" style="color:red">*
								បញ្ជាក់ពាក្យសម្ងាត់</label>
							<div class="col-sm-9">
								<input type="password"
									class="form-control @error('new_password_confirmation') is-invalid @enderror"
									id="new_password_confirmation" name="new_password_confirmation"
									placeholder="បញ្ជាក់ពាក្យសម្ងាត់">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">នាមត្រកូល</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="last_name" name="last_name"
									value="{{$userProfile->first_name}}" placeholder="ឈ្មោះ">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">ឈ្មោះ</label>
							<div class="col-sm-9">
								<input type="text" class="form-control " id="last_name" name="last_name"
									value="{{$userProfile->last_name}}" placeholder="ឈ្មោះ">
							</div>
						</div>
						<div class="form-group row">
							<div class="btn-group" style="float: right;">
								<button type="button" class="btn btn-danger"
									onclick="window.location='{{ route('user-search-case')}}'">
									<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
								</button>
								<button type="submit" class="btn btn-success">
									<i class="fas fa-save" aria-hidden="true"></i> ផ្លាស់ប្តូរពាក្យសម្ងាត់
								</button>
							</div>
						</div>


					</div><!-- /.card-body -->
				</div>
			</form>
			<!-- /.card -->
		</div>
		<div class="col-md-3">
			<!-- About Me Box -->
			<div class="card card-primary card-outline">
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

					<strong><i class="fas fa-pencil-alt mr-1"></i> ជំនាញ/Skills</strong>

					<p class="text-muted">
						{{$userProfile->skill}}
					</p>

					<hr>

					<strong><i class="far fa-file-alt mr-1"></i> កំណត់ចំណាំ/Notes</strong>

					<p class="text-muted">{{$userProfile->remark}}</p>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
	</div>
</div>
@endsection