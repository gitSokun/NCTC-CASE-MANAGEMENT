@extends('layouts.master')
@section('sidebar')
@include('sidebar.sidebarReportCaseByCountry')
<style>
.select2-container .select2-selection--single {
	box-sizing: border-box;
	cursor: pointer;
	display: block;
	height: 35px;
	user-select: none;
	-webkit-user-select: none;
}
</style>
<style>
table {
	border-collapse: collapse;
	width: 100%;
}

table td {
	padding: .20rem !important;
}

.th-header {
	font-weight: bold;
	font-size: 15px;
	/* text-align: center; */
	background-color: #3f6791;
	color: white;
	text-align: center;
}

.th-group-header {
	font-weight: bold;
	font-size: 15px;
	/* text-align: center; */
	background-color: #fd7e143b !important;
	color: black;

}

.total_tr {
	background-color: #80808094 !important;
	font-weight: bold;
	text-align: right;
}

.text_align_right {
	text-align: right;
}

.text_align_center {
	text-align: center;
}
</style>
@endsection
@section('content')
<div class="container-fluid Battambang" style="padding-top: 0px;">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<form class="form-horizontal" enctype="multipart/form-data" id="frmQueryUserReport">
						{{ csrf_field() }}
						<div class="row">

							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label class='label1' style="font-weight: 200;">ពីកាលបរិច្ឆេទ</label>
										<div class="input-group date" id="fromDate" data-target-input="nearest">
											<input type="text" class="form-control datetimepicker-input "
												data-target="#fromDate" id="from_date" name="from_date" />
											<div class="input-group-append" data-target="#fromDate"
												data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<label class='label1' style="font-weight: 200;">ទៅកាលបរិច្ឆេទ</label>
										<div class="input-group date" id="toDate" data-target-input="nearest">
											<input type="text" class="form-control datetimepicker-input "
												data-target="#toDate" id="to_date" name="to_date" />
											<div class="input-group-append" data-target="#toDate"
												data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<label class="label1" style="font-weight: 200;">ប្រទេស</label>
										<select class="custom-select rounded-0 " id="country" name="country"
											placeholder="">
											<option></option>
											@foreach($countries as $country)
											<option>{{$country->name_eng}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="btn-group" style="padding-top: 5.5%;">
									<button type="button" class="btn btn-success toastrDefaultSuccess" id="submit_form">
										<i class="fas fa-save" aria-hidden="true"></i> ស្វែងរក
									</button>
								</div>
								<div class="btn-group" style="padding-top: 5.5%;">
									<button type="button" onclick="printDiv('printDiv')" class="btn btn-info"
										id="print">
										<i class="fas fa-print" aria-hidden="true"></i> Print / Save as PDF
									</button>
								</div>

							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
<div id="printDiv" style=" padding-right: 10px; padding-left: 10px;">
	<div class="row" style="text-align: center; padding-bottom: 10px;">
		<div class="col-12" style="text-align: center;">
			<table style="width: 100%; border: none;">
				<tr style="border: none;">
					<td style="width: 100px; height: 100px; text-align: center; border: none;">
						@php
						$imagePath = public_path('dist/img/icon_nctc.png'); // Adjust path if needed
						$imageData = base64_encode(file_get_contents($imagePath));
						$imageSrc = 'data:image/png;base64,' . $imageData;
						@endphp

						<img src="{{ $imageSrc }}" alt="Case management" class="brand-image img-circle elevation-3"
							style="width: 100%; object-fit: contain;">
					</td>
					<td style="text-align: center; border: none;">
						<h2>របាយការណ៍ <br> បូកសរុបករណីតាមប្រទេស</h2>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<table style="border: none;">
			<tr style="border: none;">
				<td style="border: none;">
					ពីកាលបរិច្ឆេទ ៖ <span id="spnFromDate"></span> <span> </span>
					ទៅកាលបរិច្ឆេទ ៖ <span id="spnToDate"></span>
				</td>
			</tr>
		</table>
		<!--'show_causing_case'){//ការវាយប្រហារ-->
		<table id="tableShowCausingCase" class="table table-bordered table-striped">

			<thead>
				<!-- Header can be static or generated dynamically -->
			</thead>
			<tbody>
				<!-- jQuery will append rows here -->
			</tbody>
		</table>
	</div>
</div>
<div class="modal" id="loadingModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body text-center">
				<div class="spinner-border" role="status">
					<span class="sr-only">Loading ...</span>
				</div>

				<p>Processing...</p>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
function printDiv(divId) {
	let content = document.getElementById(divId).innerHTML;
	let printWindow = window.open('', '', 'height=600,width=800');
	printWindow.document.write('<html><head><title>Print Table</title>');
	printWindow.document.write(`
		<style>
			table { width: 100%; border-collapse: collapse; }
			table, th, td { border: 1px solid black; padding: 5px; }
			th { background-color: #3f6791; color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact;}
			.th-header {
				font-weight: bold;
				font-size: 15px;
				background-color: #3f6791 !important;
				color: white;
				text-align: center;
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}
			.th-group-header {
				font-weight: bold;
				font-size: 15px;
				background-color: #fd7e143b !important;
				color: black;
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}
			.total_tr {
				background-color: #80808094 !important;
				font-weight: bold;
				text-align: right;
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}
			.text_align_right {
				text-align: right;
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}
			.text_align_center {
				text-align: center;
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}
		</style>
	`);
	printWindow.document.write('</head><body>');
	printWindow.document.write(content);
	printWindow.document.write('</body></html>');
	printWindow.document.close();
	printWindow.focus();
	printWindow.print();
	printWindow.close();
}
</script>
<script>
$(function() {
	//Date picker
	$('#fromDate').datetimepicker({
		format: 'yyyy-M-D'
	});
	//Date picker
	$('#toDate').datetimepicker({
		format: 'yyyy-M-D'
	});
});
$(document).ready(function() {
	$("#submit_form").click(function(event) {
		event.preventDefault();

		$('#loadingModal').modal('show');

		$("#frmQueryUserReport").submit();
	});
	$('#frmQueryUserReport').submit(function(e) {
		e.preventDefault();

		$('#tbodyCausingCase').empty();
		$('#tbodyCrackdownCase').empty();
		$('#tbodyOtherCase').empty();

		var formData = new FormData(this);

		$.ajax({
			url: "{{ route('report-summary-case-by-country-search')}}", // Laravel route
			method: "POST",
			data: formData, //$(this).serialize(), // Serialize form data
			processData: false, // Don't let jQuery process the data
			contentType: false, // Don't set content type to 'application/x-www-form-urlencoded'
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
					'content') // Include CSRF token
			},
			success: function(response) {
				
				let fromDate = response.fromDate;
				let toDate = response.toDate;

				$('#spnFromDate').text(fromDate);
				$('#spnToDate').text(toDate);

				let tableBody = '';

				$.each(response.groupedData, function(country, cases) {
					console.log(country);
					tableBody += `
						<tr class="th-group-header">
							<td colspan="6">ប្រទេស ៖ ${country}<span></span></td>
						</tr>
						<tr style="
								font-weight: bold;
								font-size: 15px;
								/* text-align: center; */
								background-color: #3f6791;
								color: white;
								text-align: center;
							" class="th-header">
							<td>ល.រ</td>
							<td>សកម្មភាព</td>
							<td>ករណី</td>
							<td>ចំនួនករណីសរុប</td>
							<td>ចំនួនស្លាប់សរុប</td>
							<td>ចំនួនរបួសសរុប</td>
						</tr>
					`;
					// Loop through cases
					let totalCausingCase = 0;
					let totalDeath = 0;
					let totalInjure = 0;
					$.each(cases, function(index, item) {
						let rowNumber = index + 1;
						tableBody += `
							<tr>
								<td>${rowNumber}</td>
								<td>${item.activities_description}</td>
								<td>${item.causing_case}</td>
								<td style="text-align: right;">${item.total_causing_case}</td>
								<td style="text-align: right;">${item.total_death}</td>
								<td style="text-align: right;">${item.total_injure}</td>
							</tr>
						`;
						totalCausingCase += parseInt(item.total_causing_case);
						totalDeath += parseInt(item.total_death);
						totalInjure += parseInt(item.total_injure);
					}); 
					tableBody += `
					<tr class="total_tr">
							<td colspan="3">សរុប </td>
							<td>${totalCausingCase}</td>
							<td>${totalDeath}</td>
							<td>${totalInjure}</td>
						</tr>
						`;
				});

				$('#tableShowCausingCase tbody').html(tableBody);

				$('#loadingModal').modal('hide');
			},
			complete: function() {
				$('#loadingModal').modal('hide');
			},
			error: function(xhr) {
				$('#loadingModal').modal('hide');
				feather.replace(); // Re-render icon

				console.log(xhr);
				let errors = xhr.responseJSON.errors;

				let errorMessage = "Something went wrong!";

				if (xhr.status === 422) {
					if (errors) {
						errorMessage = Object.values(errors).map(errArray => errArray[0])
							.join(
								'<br>');
					}
					toastr.error('👋 ' + errorMessage, 'Error!', {
						closeButton: true,
						tapToDismiss: false
					});
				} else {
					toastr.error('👋 ' + errors, 'Error!', {
						closeButton: true,
						tapToDismiss: false
					});
				}
			}
		});
	});
});
</script>
@endsection