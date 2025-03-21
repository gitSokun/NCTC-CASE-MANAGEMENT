<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NCTC-ព្រឹត្តិការណ៍</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

	<!-- DataTables -->
	<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

	<!-- IonIcons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

	<!-- SimpleMDE -->
	<link rel="stylesheet" href="{{asset('plugins/simplemde/simplemde.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

	<!-- daterange picker -->
	<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
	<!-- Bootstrap Color Picker -->
	<link rel="stylesheet" href="{{asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
	<!-- Bootstrap4 Duallistbox -->
	<link rel="stylesheet" href="{{asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
	<!-- BS Stepper -->
	<link rel="stylesheet" href="{{asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
	<!-- dropzonejs -->
	<link rel="stylesheet" href="{{asset('plugins/dropzone/min/dropzone.min.css')}}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
	<!-- CodeMirror -->
	<link rel="stylesheet" href="{{asset('plugins/codemirror/codemirror.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/codemirror/theme/monokai.css')}}">



	<style>
	@font-face {
		font-family: Battambang-Regular;
		src: url("{{asset('dist/css/khmerFont/Battambang-Regular.ttf')}}");
	}

	.Battambang {
		font-family: Battambang-Regular;
	}

	.str_limit_title {
		display: block;
		width: 500px;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		color: darkblue;
	}
	.str_limit_body {
		display: block;
		width: 600px;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
	}
	</style>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini" style="font-size: 15px;">
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block Battambang ">
					<a href="{{ url('logout') }}" class="nav-link" method="POST">
						@csrf
						<i class="fas fa-sign-out-alt"></i> ចាកចេញ
					</a>
				</li>

			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Navbar Search -->


				<!-- Messages Dropdown Menu -->

				<!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="far fa-bell"></i>
						<span class="badge badge-warning navbar-badge">15</span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header">15 Notifications</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-envelope mr-2"></i> 4 new messages
							<span class="float-right text-muted text-sm">3 mins</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-users mr-2"></i> 8 friend requests
							<span class="float-right text-muted text-sm">12 hours</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-file mr-2"></i> 3 new reports
							<span class="float-right text-muted text-sm">2 days</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All
							Notifications</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-widget="fullscreen" href="#" role="button">
						<i class="fas fa-expand-arrows-alt"></i>
					</a>
				</li>
				
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a href="#" class="brand-link" data-toggle="dropdown">
						
							@if(Auth::check())
							  @if(Auth::user()->profile->file_path)
							  <img src="{{asset('avatar/'.Auth::user()->profile->file_path)}}" class="brand-image img-circle elevation-3"
							  style="opacity: .8">
							  @else
							  <img src="{{asset('dist/img/default-150x150.png')}}" class="brand-image img-circle elevation-3"
							  style="opacity: .8">
							  @endif
							
						    <span class="brand-text" style="color: #343a40;font-weight: bold;font-size: 15px;">
							{{ Auth::user()->profile->first_name}}
							{{ Auth::user()->profile->last_name}}							
							@endif </span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header"
							style="font-weight: bold; color: #343a40; padding-bottom: 0px;background-color: #007bff33;">
							@if(Auth::check())
							{{ Auth::user()->profile->first_name}}
							{{ Auth::user()->profile->last_name}}	
							@endif 
						</span>
						<span class="dropdown-item dropdown-header"
							style="padding-top: 0px;background-color: #007bff33;">
							@if(Auth::check())
							{{ Auth::user()->email}}
							@endif 
						</span>
						<div class="dropdown-divider"></div>

						<div class="dropdown-divider"></div>
						<a href="{{ url('my-profile') }}" class="dropdown-item">
							<i class="fas fa-users mr-2"></i>ព័ត៌មានផ្ទាល់ខ្លួន (Profile)
						</a>
						
						<div class="dropdown-divider"></div>
						<a href="{{ url('change-password') }}" class="nav-link dropdown-item " method="GET">
							@csrf
							<i class="fas fa-edit mr-2"></i>ផ្លាស់ប្តូរពាក្យសម្ងាត់(ChangePassword)
						</a>
						<div class="dropdown-divider"></div>
						<a href="{{ url('logout') }}" class="nav-link dropdown-item " method="POST">
							@csrf
							<i class="fas fa-sign-out-alt mr-2"></i>ចាកចេញ (Logout)
						</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">

					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header">15 Notifications</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-envelope mr-2"></i> 4 new messages
							<span class="float-right text-muted text-sm">3 mins</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-users mr-2"></i> 8 friend requests
							<span class="float-right text-muted text-sm">12 hours</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-file mr-2"></i> 3 new reports
							<span class="float-right text-muted text-sm">2 days</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All
							Notifications</a>
					</div>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="#" class="brand-link">
				<img src="{{asset('dist/img/icon_nctc.png')}}" alt="Case management"
					class="brand-image img-circle elevation-3" style="opacity: .8">
				<span class="brand-text font-weight-light">CASE MANAGEMENT</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
						data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
						@yield('sidebar')
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- =============================================== -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper Battambang">
			<!-- Content Header (Page header) -->
			<div class="content-header Battambang">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">
								@yield('title_page')
							</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right Battambang">
								@yield('breadcrumbs')
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<div class="content">
				@yield('content')

				<!-- /.container-fluid -->
			</div>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2023 <a href="#">NCTC CASE MANAGMENT</a>.</strong>
			All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 1.0.0
			</div>
		</footer>
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->

	<!-- jQuery -->
	<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
	<!-- Bootstrap -->
	<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<!-- AdminLTE -->
	<script src="{{asset('dist/js/adminlte.js')}}"></script>

	<!-- DataTables  & Plugins -->
	<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
	<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
	<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
	<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
	<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
	<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
	<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
	<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
	<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
	<script src="{{asset('plugins/codemirror/codemirror.js')}}"></script>
	<script src="{{asset('plugins/codemirror/mode/css/css.js')}}"></script>
	<script src="{{asset('plugins/codemirror/mode/xml/xml.js')}}"></script>
	<script src="{{asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js')}}"></script>
	
	<!-- Select2 -->
	<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
	<!-- Bootstrap4 Duallistbox -->
	<script src="{{asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
	<!-- InputMask -->
	<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
	<script src="{{asset('plugins/inputmask/jquery.inputmask.min.js')}}"></script>
	<!-- date-range-picker -->
	<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
	<!-- bootstrap color picker -->
	<script src="{{asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
	<!-- Bootstrap Switch -->
	<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
	<!-- BS-Stepper -->
	<script src="{{asset('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
	<!-- dropzonejs -->
	<script src="{{asset('plugins/dropzone/min/dropzone.min.js')}}"></script>
 
	<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
	<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
	
	@yield('script')
</body>

</html>

