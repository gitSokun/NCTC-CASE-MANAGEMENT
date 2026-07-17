@extends('layouts.master')
@section('sidebar')
@include('sidebar.sidebarReportUser')
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
	background-color: #3f6791 !important;
	color: white;
	text-align: center;
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
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;">ពីកាលបរិច្ឆេទបង្កើត</label>
										<div class="input-group date" id="fromDate" data-target-input="nearest">
											<input type="text" class="form-control datetimepicker-input "
												data-target="#fromDate" id="from_date" name="from_date" />
											<div class="input-group-append" data-target="#fromDate"
												data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;">ទៅកាលបរិច្ឆេទបង្កើត</label>
										<div class="input-group date" id="toDate" data-target-input="nearest">
											<input type="text" class="form-control datetimepicker-input "
												data-target="#toDate" id="to_date" name="to_date" />
											<div class="input-group-append" data-target="#toDate"
												data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<label class='label1' style="font-weight: 200;">អ្នកប្រើប្រាស់</label>
										<div class="input-group" id="user-group">
											<input type="text" class="form-control" id="user" name="user">
										</div>
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
						<h2>របាយការណ៍ករណី អ្នកប្រើប្រាស់</h2>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<table style="border: none;">
			<tr style="border: none;">
				<td style="border: none;">
					ពីកាលបរិច្ឆេទបង្កើត ៖ <span id="spnFromDate"></span><span> </span>
					ទៅកាលបរិច្ឆេទបង្កើត ៖ <span id="spnToDate"></span>
				</td>
			</tr>
		</table>
		<table id="tableUserReport" class="table table-bordered table-striped">
			<tr class="th-header">
				<td>ល.រ</td>
				<td>នាមត្រកូល</td>
				<td>ឈ្មោះ</td>
				<td>ភេទ</td>
				<td>ជំនាញ</td>
				<td>ការអប់រំ</td>
				<td>កាលបរិច្ឆេទបង្កើត</td>
				<td>សរុបមិនទាន់បកប្រែ</td>
				<td>សរុបបកប្រែរួច</td>
			</tr>
			<tbody id="tbodyUser"></tbody>
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
				text-align: center; -webkit-print-color-adjust: exact; print-color-adjust: exact;
			}
			.total_tr {
				background-color: #80808094 !important;
				font-weight: bold;
				text-align: right; -webkit-print-color-adjust: exact; print-color-adjust: exact;
			}
			.text_align_right {
				text-align: right;-webkit-print-color-adjust: exact; print-color-adjust: exact;
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

	function formatDate(dateString) {
		const date = new Date(dateString);

		const day = String(date.getDate()).padStart(2, '0');
		const month = String(date.getMonth() + 1).padStart(2, '0');
		const year = date.getFullYear();

		return `${day}-${month}-${year}`;
	}

	$('#frmQueryUserReport').submit(function(e) {
		e.preventDefault();

		$('#tbodyUser').empty();

		var formData = new FormData(this);

		$.ajax({
			url: "{{ route('report-user-search')}}", // Laravel route
			method: "POST",
			data: formData, //$(this).serialize(), // Serialize form data
			processData: false, // Don't let jQuery process the data
			contentType: false, // Don't set content type to 'application/x-www-form-urlencoded'
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
					'content') // Include CSRF token
			},
			success: function(response) {
				console.log(response);
				if (response.users) {
					var users = response.users;
					let fromDate = response.fromDate;
					let toDate = response.toDate;

					$('#spnFromDate').text(fromDate);
					$('#spnToDate').text(toDate);

					$.each(users, function(index, record) {
						let rowNumber = index + 1;
						let createdDate = formatDate(record.created_at);

						let rows = `
						<tr>
							<td>${rowNumber}</td>
							<td>${record.first_name}</td>
							<td>${record.last_name}</td>
							<td>${record.gender}</td>
							<td>${record.skill}</td>
							<td>${record.education}</td>
							<td>${createdDate}</td>
							<td class="text_align_right">${record.total_case_yet_to_translate}</td>
							<td class="text_align_right">${record.total_translate_kh}</td>
						</tr>`;
						$('#tbodyUser').append(rows);
					});

					$('#tbodyUser').append(`
					<tr class="total_tr">
						<td colspan="7">ចំនួនសរុប </td>
						<td>${response.totalNotYetKH}</td>
						<td>${response.totalTranslated}</td>
					</tr>
					`);

				}

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