@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">បង្កើតព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)</li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">

				<form class="form-horizontal" enctype="multipart/form-data" id="newcase" method="POST"
					action="{{ route('case-information-store') }}">
					{{ csrf_field() }}
					<div class="card-header">
						<div class="row">
							<div class="col-sm-6">
								<h4>បង្កើតព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)</h4>
							</div>
							<div class="col-sm-6">
								<div class="btn-group" style="float: right;">
									<button type="button" class="btn btn-danger"
										onclick="window.location='{{ route('CaseList')}}'">
										<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
									</button>
									<!--<button type="submit" class="btn btn-success toastrDefaultSuccess">
										<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុកសេចក្តីព្រាង
									</button>-->
									<button type="submit" class="btn btn-success toastrDefaultSuccess">
										<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុក
									</button>
								</div>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card-body">
								<div class="row">
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;">លេខសំគាល់ ព្រឹត្តិការណ៍</label>
										<div class="input-group ">
											<input type="text" class="form-control" id="caseNumber"
												value="{{$caseNumber}}" readonly />
										</div>
									</div>
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;">លេខសំគាល់ ព្រឹត្តិការណ៍​
											ពាក់ព័ន្ធ</label>
										<div class="input-group ">
											<input type="text" class="form-control" id="related_case_number"
												name="related_case_number" />
										</div>
									</div>
								</div>

							</div>
						</div>


						<div class="col-md-12">
							<div class="card-header">
								<h3 class="card-title label1" style="font-weight: 700;">អត្ថបទ</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label class="label1" style="font-weight: 200;color:red;">* ចំណងជើង
												(មានទាំងអត្ថបទ)</label>
											<input type="text" class="form-control @error('title') is-invalid @enderror"
												id="title" name="title" placeholder="input" value="">
											@if($errors->has('title'))
											<label for="inputSkills" class="col-sm-12 col-form-label "
												style="color:red;">{{ $errors->first('title') }}</label>
											@endif
										</div>
									</div>

									<!--@if ($errors->any())
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
									@endif-->
									<!--<div class="col-sm-12">
										<label class="label1" style="font-weight: 200;color:red;">* ខ្លឹមសាររួម
											(មានទាំង link ដើម)</label>
										<textarea id="description" name="description"
											class="@error('description') is-invalid @enderror"></textarea>
										@if($errors->has('title'))
										<label for="inputSkills" class="col-sm-12 col-form-label "
											style="color:red;">{{ $errors->first('description') }}</label>
										@endif
									</div>-->
									<div class="col-sm-12">
										<label class="label1" style="font-weight: 200;color:red;">* ខ្លឹមសារដើម
											(មានទាំង link ដើម)</label>
										<textarea id="original_source" name="original_source"
											class="@error('original_source') is-invalid @enderror"></textarea>
										@if($errors->has('original_source'))
										<label for="original_source" class="col-sm-12 col-form-label "
											style="color:red;">{{ $errors->first('original_source') }}</label>
										@endif
									</div>

								</div>

							</div>

						</div>

						<div class="col-md-6">
							<!-- /.card-header -->
							<div class="card-header">
								<h3 class="card-title label1" style="font-weight: 700;">កាលបរិច្ឆេទកើតហេតុ</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;" s>កាលបរិច្ឆេទចុះផ្សាយ</label>
										<div class="input-group date" id="reservationdate" data-target-input="nearest">
											<input type="text" class="form-control datetimepicker-input "
												data-target="#reservationdate" id="released_date"
												name="released_date" />
											<div class="input-group-append" data-target="#reservationdate"
												data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;">កាលបរិច្ឆេទជាក់ស្តែង</label>
										<div class="input-group date" id="reservationdate1" data-target-input="nearest">
											<input type="text" class="form-control datetimepicker-input "
												data-target="#reservationdate1" id="actual_date" name="actual_date" />
											<div class="input-group-append" data-target="#reservationdate1"
												data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
										<label class='label1' style="font-weight: 200;">ចំនួនស្លាប់</label>
										<input type="number" class="form-control " id="death" name="death"
											placeholder="ចំនួនស្លាប់">
									</div>
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;">ចំនួនរបួស</label>
										<input type="number" class="form-control " id="injure" name="injure"
											placeholder="ចំនួនរបួស">
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
										<input type="text" class="form-control " id="activities" name="activities"
											placeholder="សកម្មភាព">
										<!--<select class="custom-select rounded-0 " id="activities" name="activities">
											@foreach($activities as $activity)
											<option>{{$activity->name}}</option>
											@endforeach
										</select>-->
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ករណីបង្ក</label>
										<input type="text" class="form-control " id="causing_case" name="causing_case"
											placeholder="ករណីបង្ក">
										<!--<select class="custom-select rounded-0 " id="causing_case" name="causing_case">
											@foreach($causingCases as $causingCase)
											<option>{{$causingCase->name}}</option>
											@endforeach
										</select>-->
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ប្រទេស</label>
										<input type="text" class="form-control " id="country" name="country"
											placeholder="ប្រទេស">
										<!--<select class="custom-select rounded-0 " id="country" name="country">
											@foreach($countries as $country)
											<option>{{$country->name_kh}}</option>
											@endforeach
										</select>-->
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ខេត្ត</label>
										<input type="text" class="form-control " id="province_city" name="province_city"
											placeholder="ខេត្ត">
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">តំបន់</label>
										<input type="text" class="form-control " id="area" name="area"
											placeholder="តំបន់">
									</div>
									<div class="col-sm-6">
										<label class="label1"
											style="font-weight: 200;">ក្រុមបង្កហេតុ/អ្នកពាក់ព័ន្ធ</label>
										<input type="text" class="form-control " id="provocative_group"
											name="provocative_group" placeholder="ក្រុមបង្កហេតុ">
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
										<label class="label1" style="font-weight: 200;">ក្រុមរងគ្រោះ</label>
										<input type="text" class="form-control " id="victim" name="victim"
											placeholder="ក្រុមរងគ្រោះ">
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ឈ្មោះជនបង្ក</label>
										<input type="text" class="form-control " id="perpetrator_name"
											name="perpetrator_name" placeholder="ឈ្មោះជនបង្ក">
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ឈ្មោះជនរងគ្រោះ</label>
										<input type="text" class="form-control " id="victim_name" name="victim_name"
											placeholder="ឈ្មោះជនរងគ្រោះ">
									</div>
								</div>

							</div>
						</div>


						<div class="col-md-12">

							<div class="card-header">
								<h3 class="card-title label1" style="font-weight: 700;">ឯកសារពាក់ព័ន្ធ</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<div class="card card-default">
											<div class="card-body">
												<input type="file" class="form-control" name="photos[]" multiple />
											</div>

										</div>
										<!-- /.card -->
									</div>
								</div>
							</div>
							<div class="card-footer">
								<div class="btn-group" style="float: right;">
									<button type="button" class="btn btn-danger"
										onclick="window.location='{{route('CaseList')}}'">
										<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
									</button>
									<!--<button type="submit" class="btn btn-success toastrDefaultSuccess">
										<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុកសេចក្តីព្រាង
									</button>-->
									<button type="submit" class="btn btn-success toastrDefaultSuccess">
										<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុក
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>

			</div>

			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.col -->
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