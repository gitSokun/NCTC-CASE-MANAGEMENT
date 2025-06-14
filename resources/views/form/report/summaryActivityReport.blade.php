@extends('layouts.master')
@section('sidebar')
@include('sidebar.sidebarReportUser')
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

th,
td {
	text-align: left;
	padding: 0px;
}

tr:nth-child(even) {
	background-color: white;
}

th {
	background-color: #3f6791;
	color: white;
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
										<label class='label1' style="font-weight: 200;">From Date</label>
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
										<label class='label1' style="font-weight: 200;">To Date</label>
										<div class="input-group date" id="toDate" data-target-input="nearest">
											<input type="text" class="form-control datetimepicker-input "
												data-target="#toDate" id="to_date" name="to_date" />
											<div class="input-group-append" data-target="#toDate"
												data-toggle="datetimepicker">
												<div class="input-group-text"><i class="fa fa-calendar"></i></div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="btn-group" style="padding-top: 5.5%;">
									<button type="button" class="btn btn-success toastrDefaultSuccess" id="submit_form">
										<i class="fas fa-save" aria-hidden="true"></i> Search
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
	<div class="row">
		<div class="col-12" style="text-align: center;">
			<h4>REPORT USER</h4>
		</div>
	</div>
	<div class="row">
		<table id="tableUserReport" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Gender</th>
					<th>Skill</th>
					<th>Education</th>
					<th>Total cases</th>
					<th>Total Translated Case</th>
				</tr>
			</thead>
			<tbody> </tbody>
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

		$('#tableUserReport tbody').empty();

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
				

					$.each(users, function(index, record) {
						let rowNumber = index + 1;
						let rows = `
						<tr>
							<td>${rowNumber}</td>
							<td>${record.first_name}</td>
							<td>${record.last_name}</td>
							<td>${record.gender}</td>
							<td>${record.skill}</td>
							<td>${record.education}</td>
							<td>${record.total_case_yet_to_translate}</td>
							<td>${record.total_translate_kh}</td>
						</tr>`;
						$('#tableUserReport tbody').append(rows);
					});

					$('#tableUserReport tbody').append(`
					<tr>
						<td colspan="6">Total</td>
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