<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NCTC CASE MANAGEMENT</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a><b>NCTC</b><br>Case Management</a>
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Sign in to start your session</p>

				<form method="POST" action="{{ route('authenticate') }}">
					{{ csrf_field() }}

					@if (Session::get('success'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

					<div class="input-group mb-3">
						<input type="email" id="email" name="email"
							class="form-control @error('email') is-invalid @enderror" placeholder="Email"
							value="{{ old('email') }}">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
						@if ($errors->has('email'))
						<label class="error invalid-feedback">{{ $errors->first('email') }}</label>
						@endif
					</div>


					<div class="input-group mb-3">
						<input type="password" id="password" name="password"
							class="form-control @error('password') is-invalid @enderror" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
						@if ($errors->has('password'))
						<label class="error invalid-feedback">{{ $errors->first('password') }}</label>
						@endif

					</div>

					

					<div class="row">
						<div class="col-8">
							<div class="icheck-primary">
								<input type="checkbox" id="remember">
								<label for="remember">
									Remember Me
								</label>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<!-- AdminLTE App -->
	<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>

</html>