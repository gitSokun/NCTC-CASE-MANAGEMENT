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
					action="{{ route('case-information-update') }}">
					{{ csrf_field() }}
					<input class="form-control " id="id" name="id" value="{{$case->id}}" placeholder="" hidden>
					<div class="card-header">

						<div class="btn-group" style="float: right;">
							<button type="button" class="btn btn-danger"
								onclick="window.location='{{ route('CaseList')}}'">
								<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
							</button>
							<button type="submit" class="btn btn-success toastrDefaultSuccess">
								<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុក
							</button>
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
												value="{{$case->case_number}}" readonly />
										</div>
									</div>
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;">លេខសំគាល់ ព្រឹត្តិការណ៍​
											ពាក់ព័ន្ធ</label>
										<div class="input-group ">
											<input type="text" class="form-control" id="related_case_number"
												name="related_case_number" value="{{$case->related_case_number}}" />
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
												id="title" name="title" placeholder="input" value="{{$case->title}}">
											@if($errors->has('title'))
											<label for="inputSkills" class="col-sm-12 col-form-label "
												style="color:red;">{{ $errors->first('title') }}</label>
											@endif
										</div>
									</div>
									<!--<div class="col-sm-12">
										<label class="label1" style="font-weight: 200;color:red;">* ខ្លឹមសាររួម
											(មានទាំង link ដើម)</label>
										<textarea id="description" name="description"
											class="@error('description') is-invalid @enderror">{{$case->description}}</textarea>
										@if($errors->has('title'))
										<label for="inputSkills" class="col-sm-12 col-form-label "
											style="color:red;">{{ $errors->first('description') }}</label>
										@endif
									</div>-->
									<div class="col-sm-12">
										<label class="label1" style="font-weight: 200;color:red;">* ខ្លឹមសារដើម
											(មានទាំង link ដើម)</label>
										<textarea id="original_source" name="original_source"
											class="@error('original_source') is-invalid @enderror">{{$case->original_source}}</textarea>
										@if($errors->has('title'))
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
												data-target="#reservationdate" id="released_date" name="released_date"
												value="{{$case->released_date}}" />

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
												data-target="#reservationdate1" id="actual_date" name="actual_date"
												value="{{$case->actual_date}}" />
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
											placeholder="សូមបញ្ចូលព័ត៌មាន" value="{{$case->death}}">
									</div>
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;">ចំនួនរបួស</label>
										<input type="number" class="form-control " id="injure" name="injure"
											placeholder="សូមបញ្ចូលព័ត៌មាន" value="{{$case->injure}}">
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
											placeholder="សូមបញ្ចូលព័ត៌មាន" value="{{$case->activities}}">

										<!--<select class="custom-select rounded-0 " id="activities" name="activities">
											@foreach($activities as $activity)
											<option {{$activity->name == $case->activities  ? 'selected' : ''}}>
												{{$activity->name}}</option>
											@endforeach
										</select>-->
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ករណីបង្ក</label>
										<input type="text" class="form-control " id="causing_case" name="causing_case"
											placeholder="សូមបញ្ចូលព័ត៌មាន" value="{{$case->causing_case}}">
										<!--<select class="custom-select rounded-0 " id="causing_case" name="causing_case">
											@foreach($causingCases as $causingCase)
											<option {{$causingCase->name == $case->causing_case  ? 'selected' : ''}}>
												{{$causingCase->name}}</option>
											@endforeach
										</select>-->
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ប្រទេស</label>
										<input type="text" class="form-control " id="country" name="country"
											placeholder="សូមបញ្ចូលព័ត៌មាន" value="{{$case->country}}">
										<!--<select class="custom-select rounded-0 " id="country" name="country">
											@foreach($countries as $country)
											<option value="{{$country->name_kh}}"
												{{$country->name_kh == $case->country  ? 'selected' : ''}}>
												{{$country->name_kh}}</option>
											@endforeach
										</select>-->
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ខេត្ត</label>
										<input type="text" class="form-control " id="province_city" name="province_city"
											placeholder="សូមបញ្ចូលព័ត៌មាន" value="{{$case->province_city}}">
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">តំបន់</label>
										<input type="text" class="form-control " id="area" name="area"
											placeholder="សូមបញ្ចូលព័ត៌មាន" value="{{$case->area}}">
									</div>
									<div class="col-sm-6">
										<label class="label1"
											style="font-weight: 200;">ក្រុមបង្កហេតុ/អ្នកពាក់ព័ន្ធ</label>
										<input type="text" class="form-control " id="provocative_group"
											name="provocative_group" placeholder="សូមបញ្ចូលព័ត៌មាន"
											value="{{$case->provocative_group}}">
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
											placeholder="សូមបញ្ចូលព័ត៌មាន" value="{{$case->victim}}">
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ឈ្មោះជនបង្ក</label>
										<input type="text" class="form-control " id="perpetrator_name"
											name="perpetrator_name" placeholder="សូមបញ្ចូលព័ត៌មាន"
											value="{{$case->perpetrator_name}}">
									</div>
									<div class="col-sm-6">
										<label class="label1" style="font-weight: 200;">ឈ្មោះជនរងគ្រោះ</label>
										<input type="text" class="form-control " id="victim_name" name="victim_name"
											placeholder="សូមបញ្ចូលព័ត៌មាន" value="{{$case->victim_name}}">
									</div>
								</div>

							</div>
						</div>

						<div class="col-md-12">
							
							<div class="card-body">
								<div class="row">
									

									<div class="col-sm-12">

										<div class="card-header">
											<h3 class="card-title">ការបង្ហោះឯកសារពាក់ព័ន្ធ(Attach file)</h3>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-md-12">
													<div class="card card-default">
														<div class="card-body">
															<input type="file" class="form-control" name="photos[]"
																multiple />
														</div>

													</div>
													<!-- /.card -->
												</div>
											</div>
										</div>
									</div>

								</div>

							</div>

						</div>

						<div class="col-md-12">
							<div class="card-footer">
								<div class="btn-group" style="float: right;">
									<button type="button" class="btn btn-danger"
										onclick="window.location='{{route('CaseList')}}'">
										<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
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
			<div class="card">
				<div class="card-header">
					<div class=" Battambang">
						<div class="row">
							<div class="col-sm-6">
								<h4>បញ្ជីឯកសារ</h4>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table border="1" style="width:100%" ;>
						<tr>
							<th style="width:10%">File</th>
							<th>Name</th>
							<th style="width:12%"> Action</th>
						</tr>
						@foreach($caseUploads as $file)
						<tr>
							<td>
								<div style="height: 61px; line-height: 61px; text-align: center;">
									<span style="display: inline-block; vertical-align: middle; line-height: normal;"
										class="info-box-icon bg-besic">
										<i class="far fa-file fa-3x"></i>
									</span>

								</div>
							</td>
							<td>{{$file->file_name}}</td>
							<td>
								<form class="form-horizontal" id="upload-case" method="POST"
									action="{{ route('case-upload-remove') }}">
									{{ csrf_field() }}
									<input class="form-control " id="id" name="id" value="{{Crypt::encrypt($case->id)}}"
										placeholder="" hidden>
									<input class="form-control " id="case_upload_id" name="case_upload_id"
										value="{{Crypt::encrypt($file->id)}}" placeholder="" hidden>
									<button type="submit" class="btn btn-danger" onclick="return confirm('តើអ្នកប្រាកដថាចង់លុបឯកសារ ?')">
										<i class="fas fa-trash" aria-hidden="true"></i> លុបឯកសារ
									</button>
								</form>
							</td>
						</tr>
						@endforeach

					</table>
				</div>
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
	$('#description').summernote()
	$('#original_source').summernote()

	// CodeMirror
	CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
		mode: "htmlmixed",
		theme: "monokai"
	});

	$("#example1").DataTable({
		"responsive": true,
		"lengthChange": false,
		"autoWidth": false,
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
	}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
	$('#example2').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": true,
	});
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
	//$('#datemask').inputmask('dd/mm/yyyy', {
	//	'placeholder': 'dd/mm/yyyy'
	//})
	////Datemask2 mm/dd/yyyy
	//$('#datemask2').inputmask('mm/dd/yyyy', {
	//	'placeholder': 'mm/dd/yyyy'
	//})
	//Money Euro
	//$('[data-mask]').inputmask()

	//Date picker
	$('#reservationdate').datetimepicker({
		format: 'yyyy-mm-DD'
	});
	//Date picker
	$('#reservationdate1').datetimepicker({
		format: 'yyyy-mm-DD'
	});

	//Date and time picker
	//$('#reservationdatetime').datetimepicker({
	//	icons: {
	//		time: 'far fa-clock'
	//	}
	//});

	//Date range picker
	//$('#reservation').daterangepicker()
	////Date range picker with time picker
	//$('#reservationtime').daterangepicker({
	//	timePicker: true,
	//	timePickerIncrement: 30,
	//	locale: {
	//		format: 'MM/DD/YYYY hh:mm A'
	//	}
	//})
	//Date range as a button
	//$('#daterange-btn').daterangepicker({
	//		ranges: {
	//			'Today': [moment(), moment()],
	//			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	//			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	//			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	//			'This Month': [moment().startOf('month'), moment().endOf('month')],
	//			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
	//				.endOf('month')
	//			]
	//		},
	//		startDate: moment().subtract(29, 'days'),
	//		endDate: moment()
	//	},
	//	function(start, end) {
	//		$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
	//	}
	//)

	//Timepicker
	//$('#timepicker').datetimepicker({
	//	format: 'LT'
	//})



	$("input[data-bootstrap-switch]").each(function() {
		$(this).bootstrapSwitch('state', $(this).prop('checked'));
	})

})
// BS-Stepper Init
document.addEventListener('DOMContentLoaded', function() {
	window.stepper = new Stepper(document.querySelector('.bs-stepper'))
})

// DropzoneJS Demo Code Start
Dropzone.autoDiscover = false

// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
var previewNode = document.querySelector("#template")
previewNode.id = ""
var previewTemplate = previewNode.parentNode.innerHTML
previewNode.parentNode.removeChild(previewNode)

var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
	url: "/target-url", // Set the url
	thumbnailWidth: 80,
	thumbnailHeight: 80,
	parallelUploads: 20,
	previewTemplate: previewTemplate,
	autoQueue: false, // Make sure the files aren't queued until manually added
	previewsContainer: "#previews", // Define the container to display the previews
	clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
})

myDropzone.on("addedfile", function(file) {
	// Hookup the start button
	file.previewElement.querySelector(".start").onclick = function() {
		myDropzone.enqueueFile(file)
	}
})

// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
	document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
})

myDropzone.on("sending", function(file) {
	// Show the total progress bar when upload starts
	document.querySelector("#total-progress").style.opacity = "1"
	// And disable the start button
	file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
})

// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
	document.querySelector("#total-progress").style.opacity = "0"
})

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
document.querySelector("#actions .start").onclick = function() {
	myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
}
document.querySelector("#actions .cancel").onclick = function() {
	myDropzone.removeAllFiles(true)
}
// DropzoneJS Demo Code End
</script>
@endsection