@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">កែសម្រួលព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)</li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
@endsection
@section('content')
<div class="container-fluid Battambang">
	<div class="row">
		<div class="col-md-12 ">
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

						<div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
							aria-labelledby="custom-tabs-three-home-tab">
							<div class="card">

								<form class="form-horizontal" enctype="multipart/form-data" id="newcase" method="POST"
									action="{{ route('khmer-case-information-update')}}">
									{{ csrf_field() }}
									<input class="form-control " id="kh_case_id" name="kh_case_id" value="{{$caseKH->id}}" placeholder="" hidden>
									<div class="card-header">
										<div class="row">
											<div class="col-sm-6">
												<label class='label1' style="font-weight: 200;">លេខសំគាល់ព្រឹត្តិការណ៍
													<br> {{$caseKH->case_number}}</label>
											</div>
											<div class="col-sm-6">
												<div class="btn-group" style="float: right;">
													<button type="button" class="btn btn-danger"
														onclick="window.location='{{ route('CaseList')}}'">
														<i class="fas fa-arrow-circle-left" aria-hidden="true"></i>
														ត្រលប់ក្រោយ
													</button>
													<button type="submit" class="btn btn-success toastrDefaultSuccess">
														<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុក
													</button>
												</div>
											</div>
										</div>

									</div>

									<div class="row">

										<div class="col-md-12">
											<div class="card-header">
												<h3 class="card-title label1" style="font-weight: 700;">អត្ថបទ</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<label class="label1" style="font-weight: 200;color:red;">*
																ចំណងជើង</label>
															<input type="text"
																class="form-control @error('title') is-invalid @enderror"
																id="title" name="title" placeholder="input" value="{{$caseKH->title}}">
															@if($errors->has('title'))
															<label for="inputSkills" class="col-sm-12 col-form-label "
																style="color:red;">{{ $errors->first('title') }}</label>
															@endif
														</div>
													</div>


													<div class="col-sm-12">
														<label class="label1" style="font-weight: 200;color:red;">*
															ខ្លឹមសាររួម</label>
														<textarea id="description" name="description"
															class="@error('description') is-invalid @enderror">{{$caseKH->description}}</textarea>
														@if($errors->has('description'))
														<label for="inputSkills" class="col-sm-12 col-form-label "
															style="color:red;">{{ $errors->first('description') }}</label>
														@endif
													</div>
												</div>

											</div>

										</div>

										<div class="col-md-6">
											<!-- /.card-header -->
											<div class="card-header">
												<h3 class="card-title label1" style="font-weight: 700;">
													កាលបរិច្ឆេទកើតហេតុ</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-6">
														<label class='label1' style="font-weight: 200;"
															s>កាលបរិច្ឆេទចុះផ្សាយ</label>
														<div class="input-group date" id="reservationdate"
															data-target-input="nearest">
															<input type="text"
																class="form-control datetimepicker-input "
																data-target="#reservationdate" id="released_date"
																name="released_date" value="{{$caseKH->released_date}}"  />
															<div class="input-group-append"
																data-target="#reservationdate"
																data-toggle="datetimepicker">
																<div class="input-group-text"><i
																		class="fa fa-calendar"></i></div>
															</div>
														</div>
													</div>
													<div class="col-sm-6">
														<label class='label1'
															style="font-weight: 200;">កាលបរិច្ឆេទជាក់ស្តែង</label>
														<div class="input-group date" id="reservationdate1"
															data-target-input="nearest">
															<input type="text"
																class="form-control datetimepicker-input "
																data-target="#reservationdate1" id="actual_date"
																name="actual_date"  value="{{$caseKH->actual_date}}"/>
															<div class="input-group-append"
																data-target="#reservationdate1"
																data-toggle="datetimepicker">
																<div class="input-group-text"><i
																		class="fa fa-calendar"></i></div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
										<div class="col-md-6">
											<!-- /.card-header -->
											<div class="card-header">
												<h3 class="card-title label1" style="font-weight: 700;">ការខាតបង់</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-6">
														<label class='label1'
															style="font-weight: 200;">ចំនួនស្លាប់</label>
														<input type="number" class="form-control " id="death"
															name="death" placeholder="ចំនួនស្លាប់" value="{{$caseKH->death}}">
													</div>
													<div class="col-sm-6">
														<label class='label1'
															style="font-weight: 200;">ចំនួនរបួស</label>
														<input type="number" class="form-control " id="injure"
															name="injure" placeholder="ចំនួនរបួស" value="{{$caseKH->injure}}">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<!-- /.card-header -->
											<div class="card-header">
												<h3 class="card-title label1" style="font-weight: 700;">ខ្លឹមសារ</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-6">
														<label class="label1" style="font-weight: 200;">សកម្មភាព</label>
														<input type="text" class="form-control " id="activities"
															name="activities" placeholder="សកម្មភាព" value="{{$caseKH->activities}}">

													</div>
													<div class="col-sm-6">
														<label class="label1" style="font-weight: 200;">ករណីបង្ក</label>
														<input type="text" class="form-control " id="causing_case"
															name="causing_case" placeholder="ករណីបង្ក" value="{{$caseKH->causing_case}}">

													</div>
													<div class="col-sm-6">
														<label class="label1" style="font-weight: 200;">ប្រទេស</label>
														<input type="text" class="form-control " id="country"
															name="country" placeholder="ប្រទេស" value="{{$caseKH->country}}">

													</div>
													<div class="col-sm-6">
														<label class="label1" style="font-weight: 200;">ខេត្ត</label>
														<input type="text" class="form-control " id="province_city"
															name="province_city" placeholder="ខេត្ត" value="{{$caseKH->province_city}}" >
													</div>
													<div class="col-sm-6">
														<label class="label1" style="font-weight: 200;">តំបន់</label>
														<input type="text" class="form-control " id="area" name="area"
															placeholder="តំបន់" value="{{$caseKH->area}}">
													</div>
													<div class="col-sm-6">
														<label class="label1"
															style="font-weight: 200;">ក្រុមបង្កហេតុ/អ្នកពាក់ព័ន្ធ</label>
														<input type="text" class="form-control " id="provocative_group"
															name="provocative_group" placeholder="ក្រុមបង្កហេតុ"  value="{{$caseKH->provocative_group}}" >
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<div class="card-header">
												<h3 class="card-title label1" style="font-weight: 700;">ក្រុមជនបង្ក</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-6">
														<label class="label1"
															style="font-weight: 200;">ក្រុមរងគ្រោះ</label>
														<input type="text" class="form-control " id="victim"
															name="victim" placeholder="ក្រុមរងគ្រោះ" value="{{$caseKH->victim}}" >
													</div>
													<div class="col-sm-6">
														<label class="label1"
															style="font-weight: 200;">ឈ្មោះជនបង្ក</label>
														<input type="text" class="form-control " id="perpetrator_name"
															name="perpetrator_name" placeholder="ឈ្មោះជនបង្ក" value="{{$caseKH->perpetrator_name}}" >
													</div>
													<div class="col-sm-6">
														<label class="label1"
															style="font-weight: 200;">ឈ្មោះជនរងគ្រោះ</label>
														<input type="text" class="form-control " id="victim_name"
															name="victim_name" placeholder="ឈ្មោះជនរងគ្រោះ" value="{{$caseKH->victim_name}}" >
													</div>
												</div>

											</div>
										</div>


										<div class="col-md-12">
											<div class="card-footer">
												<div class="btn-group" style="float: right;">
													<button type="button" class="btn btn-danger"
														onclick="window.location='{{route('CaseList')}}'">
														<i class="fas fa-arrow-circle-left" aria-hidden="true"></i>
														ត្រលប់ក្រោយ
													</button>
													<button type="submit" class="btn btn-success toastrDefaultSuccess">
														<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុក
													</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>

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
@section('script')
<script>
$(function() {
	$('#description').summernote();
	$('#original_source').summernote()


});
</script>

<script>
$(function() {
	//Initialize Select2 Elements
	$('.select2').select2()

	//Initialize Select2 Elements
	$('.select2bs4').select2({
		theme: 'bootstrap4'
	})

	//Datemask dd/mm/yyyy
	$('#datemask').inputmask('dd/mm/yyyy', {
		'placeholder': 'dd/mm/yyyy'
	})
	//Datemask2 mm/dd/yyyy
	$('#datemask2').inputmask('mm/dd/yyyy', {
		'placeholder': 'mm/dd/yyyy'
	})
	//Money Euro
	$('[data-mask]').inputmask()

	//Date picker
	$('#reservationdate').datetimepicker({
		format: 'L'
	});
	//Date picker
	$('#reservationdate1').datetimepicker({
		format: 'L'
	});

	//Date and time picker
	$('#reservationdatetime').datetimepicker({
		icons: {
			time: 'far fa-clock'
		}
	});

	//Date range picker
	$('#reservation').daterangepicker()
	//Date range picker with time picker
	$('#reservationtime').daterangepicker({
		timePicker: true,
		timePickerIncrement: 30,
		locale: {
			format: 'MM/DD/YYYY hh:mm A'
		}
	})

	//Timepicker
	$('#timepicker').datetimepicker({
		format: 'LT'
	})

	//Bootstrap Duallistbox
	$('.duallistbox').bootstrapDualListbox()

	//Colorpicker
	$('.my-colorpicker1').colorpicker()
	//color picker with addon
	$('.my-colorpicker2').colorpicker()

	$('.my-colorpicker2').on('colorpickerChange', function(event) {
		$('.my-colorpicker2 .fa-square').css('color', event.color.toString());
	})

	$("input[data-bootstrap-switch]").each(function() {
		$(this).bootstrapSwitch('state', $(this).prop('checked'));
	})

})
</script>
@endsection