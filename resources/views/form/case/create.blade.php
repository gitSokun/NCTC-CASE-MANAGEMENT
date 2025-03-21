@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">បង្កើតព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)</li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
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
	background-color: #4caf50;
	color: white;
}
</style>
@endsection
@section('content')
<div class="container-fluid Battambang">
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
											</label>
											<input type="text" class="form-control @error('title') is-invalid @enderror"
												id="title" name="title" placeholder="input" value="">
											@if($errors->has('title'))
											<label for="inputSkills" class="col-sm-12 col-form-label "
												style="color:red;">{{ $errors->first('title') }}</label>
											@endif
										</div>
									</div>
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



						<div class="col-md-12">
							<!-- /.card-header -->
							<div class="card-header">
								<h3 class="card-title label1" style="font-weight: 700;">ការខាតបង់</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-3">
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
									<div class="col-sm-3">
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
									<div class="col-sm-3">
										<label class='label1' style="font-weight: 200;">ចំនួនស្លាប់</label>
										<input type="number" class="form-control " id="death" name="death"
											placeholder="">
									</div>
									<div class="col-sm-3">
										<label class='label1' style="font-weight: 200;">ចំនួនរបួស</label>
										<input type="number" class="form-control " id="injure" name="injure"
											placeholder="">
									</div>
									<div class="col-sm-3">
										<label class='label1' style="font-weight: 200;">ចំនួនឃុំខ្លួន</label>
										<input type="number" class="form-control " id="detention" name="detention"
											placeholder="">
									</div>
									<div class="col-sm-3">
										<label class='label1' style="font-weight: 200;">ផ្លាស់ទីលំនៅ</label>
										<input type="number" class="form-control " id="relocate" name="relocate"
											placeholder="">
									</div>
									<div class="col-sm-3">
										<label class='label1' style="font-weight: 200;">ចំណាកស្រុក</label>
										<input type="number" class="form-control " id="migration" name="migration"
											placeholder="">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="card-header">
							<h3 class="card-title label1" style="font-weight: 700;">ករណីបង្ក</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">សកម្មភាព</label>
									<select class="custom-select rounded-0 " id="activities" name="activities"
										placeholder="">
										<option> </option>
										@foreach($actions as $action)
										<option>{{$action->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">ករណីបង្ក</label>
									<input type="text" class="form-control " id="causing_case" name="causing_case"
										placeholder="">
								</div>
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">ប្រទេស</label>
									<div class="form-group">
										<select class="select2" data-placeholder="" id="country" name="country"
											style="width: 100%; height: 40%;">
											<option></option>
											@foreach($countries as $country)
											<option>{{$country->name_eng}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">ខេត្ត</label>
									<input type="text" class="form-control " id="province_city" name="province_city"
										placeholder="">
								</div>
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">តំបន់</label>
									<input type="text" class="form-control " id="area" name="area" placeholder="">
								</div>
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">ក្រុមបង្កហេតុ/អ្នកពាក់ព័ន្ធ</label>
									<input type="text" class="form-control " id="provocative_group"
										name="provocative_group" placeholder="">
								</div>
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">ក្រុមរងគ្រោះ</label>
									<input type="text" class="form-control " id="victim" name="victim" placeholder="">
								</div>
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">ឈ្មោះជនបង្ក</label>
									<input type="text" class="form-control " id="perpetrator_name"
										name="perpetrator_name" placeholder="">
								</div>
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">ឈ្មោះជនរងគ្រោះ</label>
									<input type="text" class="form-control " id="victim_name" name="victim_name"
										placeholder="">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="card-header">
							<h3 class="card-title label1" style="font-weight: 700;">ករណីបង្ក្រាប</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<label class="label1" style="font-weight: 200;">ករណីបង្កហេតុ</label>
									<input type="text" class="form-control " id="provocative_case"
										name="provocative_case" placeholder="">
								</div>
								<div class="col-sm-3">
								</div>
								<div class="col-sm-3">
								</div>
								<div class="col-sm-3">
								</div>
								
								<!----------------អ្នកបង្រ្កាប-------------->
								<div class="col-sm-6">
									<div class="card-header" style="padding-left: 0px; padding-top: 30px;">
										<h3 class="card-title label1" style="padding-right: 10px;">
											<button type="button" class="btn btn-success btn-xs"
												id="btnAddMoreProvocative">
												<i class="fas fa-plus" aria-hidden="true"></i>
											</button> អ្នកបង្រ្កាប
										</h3>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<table id="suppressorsTable" style="width:100%">
												<tbody>
													<tr>
														<td>
															<div class="input-group">
																<button type="button" class="btn btn-danger btn-xs"
																	id="btnRemoveProvocative">
																	<i class="fas fa-minus" aria-hidden="true"></i>
																</button>
																<div class="input-group-prepend">
																	<span class="input-group-text">អង្គភាព</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="suppressors_orgs" name="suppressors_orgs[]">

																<div class="input-group-prepend">
																	<span class="input-group-text">បុគ្គល/ក្រុម</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="suppressor_groups"
																	name="suppressor_groups[]">
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!------------------អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ------------------>
								<div class="col-sm-6">
									<div class="card-header" style="padding-left: 0px; padding-top: 30px;">
										<h3 class="card-title label1" style="padding-right: 10px;">
											<button type="button" class="btn btn-success btn-xs"
												id="btnAddMoreAttacker">
												<i class="fas fa-plus" aria-hidden="true"></i>
											</button> អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ
										</h3>

									</div>
									<div class="row">
										<div class="col-sm-12">
											<table id="attackerTable" style="width:100%">
												<tbody>
													<tr>
														<td>
															<div class="input-group">
																<button type="button" class="btn btn-danger btn-xs"
																	id="btnRemoveAttacker">
																	<i class="fas fa-minus" aria-hidden="true"></i>
																</button>
																<div class="input-group-prepend">
																	<span class="input-group-text">អង្គភាព</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="attack_orgs" name="attack_orgs[]">

																<div class="input-group-prepend">
																	<span class="input-group-text">បុគ្គល/ក្រុម</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="attack_groups" name="attack_groups[]">


															</div>

														</td>

													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!------------------ អ្នកដែលត្រូវបានបង្ក្រាប ------------------>
								<div class="col-sm-6">
									<div class="card-header" style="padding-left: 0px; padding-top: 30px;">
										<h3 class="card-title label1" style="padding-right: 10px;">
											<button type="button" class="btn btn-success btn-xs"
												id="btnAddMoreSuppressed">
												<i class="fas fa-plus" aria-hidden="true"></i>
											</button> អ្នកដែលត្រូវបានបង្ក្រាប
										</h3>

									</div>
									<div class="row">
										<div class="col-sm-12">
											<table id="SuppressedTable" style="width:100%">
												<tbody>
													<tr>
														<td>
															<div class="input-group">
																<button type="button" class="btn btn-danger btn-xs"
																	id="btnRemoveSuppressed">
																	<i class="fas fa-minus" aria-hidden="true"></i>
																</button>
																<div class="input-group-prepend">
																	<span class="input-group-text">អង្គភាព</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="suppressed_orgs" name="suppressed_orgs[]">

																<div class="input-group-prepend">
																	<span class="input-group-text">បុគ្គល/ក្រុម</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="suppressed_groups" name="suppressed_groups[]">


															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!------------------ អ្នករងគ្រោះ ------------------>
								<div class="col-sm-6">
									<div class="card-header" style="padding-left: 0px; padding-top: 30px;">
										<h3 class="card-title label1" style="padding-right: 10px;">
											<button type="button" class="btn btn-success btn-xs" id="btnAddMoreVictim">
												<i class="fas fa-plus" aria-hidden="true"></i>
											</button>
											អ្នករងគ្រោះ
										</h3>

									</div>
									<div class="row">
										<div class="col-sm-12">
											<table id="VictimTable" style="width:100%">
												<tbody>
													<tr>
														<td>
															<div class="input-group">
																<button type="button" class="btn btn-danger btn-xs"
																	id="btnRemoveVictim">
																	<i class="fas fa-minus" aria-hidden="true"></i>
																</button>
																<div class="input-group-prepend">
																	<span class="input-group-text">អង្គភាព</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="victim_orgs" name="victim_orgs[]">

																<div class="input-group-prepend">
																	<span class="input-group-text">បុគ្គល/ក្រុម</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="victim_groups" name="victim_groups[]">


															</div>

														</td>

													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!------------------ ទីតាំងបង្ក្រាប ------------------>
								<div class="col-sm-12">
									<div class="card-header" style="padding-left: 0px; padding-top: 30px;">
										<h3 class="card-title label1" style="padding-right: 10px;">
											<button type="button" class="btn btn-success btn-xs"
												id="btnAddMoreCrackdownLocation">
												<i class="fas fa-plus" aria-hidden="true"></i>
											</button>
											ទីតាំងបង្ក្រាប
										</h3>

									</div>
									<div class="row">
										<div class="col-sm-12">
											<table id="CrackdownLocationTable" style="width:100%">
												<tbody>
													<tr>
														<td>
															<div class="input-group">
																<button type="button" class="btn btn-danger btn-xs"
																	id="btnRemoveCrackdownLocation">
																	<i class="fas fa-minus" aria-hidden="true"></i>
																</button>
																<div class="input-group-prepend">
																	<span class="input-group-text">ប្រទេស</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="crackdown_countries" name="crackdown_countries[]">

																<div class="input-group-prepend">
																	<span class="input-group-text">ខេត្ត/ក្រុង</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="crackdown_provinces" name="crackdown_provinces[]">

																<div class="input-group-prepend">
																	<span class="input-group-text">តំបន់</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="crackdown_areas" name="crackdown_areas[]">


															</div>

														</td>

													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!------------------ ទីតាំងវាយប្រហារ ------------------>
								<div class="col-sm-12">
									<div class="card-header" style="padding-left: 0px; padding-top: 30px;">
										<h5 class="card-title label1" style="padding-right: 10px;">
											<button type="button" class="btn btn-success btn-xs"
												id="btnAddMoreAttackLocation">
												<i class="fas fa-plus" aria-hidden="true"></i>
											</button> ទីតាំងវាយប្រហារ
										</h5>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<table id="AttackLocationTable" style="width:100%">
												<tbody>
													<tr>
														<td>
															<div class="input-group">
																<button type="button" class="btn btn-danger btn-xs"
																	id="btnRemoveAttackLocation">
																	<i class="fas fa-minus" aria-hidden="true"></i>
																</button>
																<div class="input-group-prepend">
																	<span class="input-group-text">ប្រទេស</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="attacked_countries" name="attacked_countries[]">

																<div class="input-group-prepend">
																	<span class="input-group-text">ខេត្ត/ក្រុង</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="attacked_provinces" name="attacked_provinces[]">

																<div class="input-group-prepend">
																	<span class="input-group-text">តំបន់</span>
																</div>
																<input type="text" class="form-control" placeholder=""
																	id="attacked_areas" name="attacked_areas[]">


															</div>

														</td>

													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group" style="padding-top: 30px;">
										<label>សម្ភារៈផ្សេងទៀត</label>
										<textarea class="form-control" rows="3" name="other_material" placeholder=""></textarea>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group" style="padding-top: 30px;">
										<label>ការខាតបង់ផ្សេងទៀត</label>
										<textarea class="form-control" rows="3" name="other_losses" placeholder=""></textarea>
									</div>
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
$(document).ready(function() {
	//<!------------------ ទីតាំងវាយប្រហារ ------------------>
	$("#btnAddMoreAttackLocation").click(function() {
		var newRow =
			'<tr>' +
			'<td>' +
			'<div class="input-group">' +
			'<button type="button" class="btn btn-danger btn-xs" id="btnRemoveAttackLocation">' +
			'<i class="fas fa-minus" aria-hidden="true"></i>' +
			'</button>' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">ប្រទេស</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="attacked_countries" name="attacked_countries[]">' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">ខេត្ត/ក្រុង</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="attacked_provinces" name="attacked_provinces[]">' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">តំបន់</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="attacked_areas" name="attacked_areas[]">' +

			'</div>' +
			'</td>' +
			'</tr>';
		$("#AttackLocationTable tbody").append(newRow);
	});

	// Remove row button click event
	$(document).on("click", "#btnRemoveAttackLocation", function() {
		$(this).closest("tr").remove();
	});
	//<!------------------ ទីតាំងបង្ក្រាប ------------------>
	$("#btnAddMoreCrackdownLocation").click(function() {
		var newRow =
			'<tr>' +
			'<td>' +
			'<div class="input-group">' +
			'<button type="button" class="btn btn-danger btn-xs" id="btnRemoveCrackdownLocation">' +
			'<i class="fas fa-minus" aria-hidden="true"></i>' +
			'</button>' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">ប្រទេស</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="crackdown_countries" name="crackdown_countries[]">' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">ខេត្ត/ក្រុង</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="crackdown_provinces" name="crackdown_provinces[]">' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">តំបន់</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="crackdown_areas" name="crackdown_areas[]">' +

			'</div>' +
			'</td>' +
			'</tr>';
		$("#CrackdownLocationTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveCrackdownLocation", function() {
		$(this).closest("tr").remove();
	});

	//<!------------------ អ្នករងគ្រោះ ------------------>
	$("#btnAddMoreVictim").click(function() {
		var newRow =
			'<tr>' +
			'<td>' +
			'<div class="input-group">' +
			'<button type="button" class="btn btn-danger btn-xs" id="btnRemoveVictim">' +
			'<i class="fas fa-minus" aria-hidden="true"></i>' +
			'</button>' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">អង្គភាព</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="victim_orgs" name="victim_orgs[]">' +
			'<div class="input-group-prepend">' +
			'	<span class="input-group-text">បុគ្គល/ក្រុម</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="victim_groups" name="victim_groups[]">' +

			'</div>' +
			'</div>' +
			'</td>' +
			'</tr>';
		$("#VictimTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveVictim", function() {
		$(this).closest("tr").remove();
	});

	//===============  អ្នកដែលត្រូវបានបង្ក្រាប  =================
	$("#btnAddMoreSuppressed").click(function() {
		var newRow =
			'<tr>' +
			'<td>' +
			'<div class="input-group">' +
			'<button type="button" class="btn btn-danger btn-xs" id="btnRemoveSuppressed">' +
			'<i class="fas fa-minus" aria-hidden="true"></i>' +
			'</button>' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">អង្គភាព</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="suppressed_orgs" name="suppressed_orgs[]">' +
			'<div class="input-group-prepend">' +
			'	<span class="input-group-text">បុគ្គល/ក្រុម</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="suppressed_groups" name="suppressed_groups[]">' +

			'</div>' +
			'</div>' +
			'</td>' +
			'</tr>';
		$("#SuppressedTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveSuppressed", function() {
		$(this).closest("tr").remove();
	});

	//===============្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ============
	$("#btnAddMoreAttacker").click(function() {
		var newRow =
			'<tr>' +
			'<td>' +
			'<div class="input-group">' +
			'<button type="button" class="btn btn-danger btn-xs" id="btnRemoveAttacker">' +
			'<i class="fas fa-minus" aria-hidden="true"></i>' +
			'</button>' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">អង្គភាព</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="attack_orgs" name="attack_orgs[]">' +
			'<div class="input-group-prepend">' +
			'	<span class="input-group-text">បុគ្គល/ក្រុម</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="attack_groups" name="attack_groups[]">' +

			'</div>' +
			'</div>' +
			'</td>' +
			'</tr>';
		$("#attackerTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveAttacker", function() {
		$(this).closest("tr").remove();
	});

	//<!----------------អ្នកបង្រ្កាប-------------->
	$("#btnAddMoreProvocative").click(function() {
		var newRow =
			'<tr>' +
			'<td>' +
			'<div class="input-group">' +
			'<button type="button" class="btn btn-danger btn-xs" id="btnRemoveProvocative">' +
			'<i class="fas fa-minus" aria-hidden="true"></i>' +
			'</button>' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">អង្គភាព</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="suppressors_orgs" name="suppressors_orgs[]">' +
			'<div class="input-group-prepend">' +
			'<span class="input-group-text">បុគ្គល/ក្រុម</span>' +
			'</div>' +
			'<input type="text" class="form-control" placeholder="" id="suppressor_groups" name="suppressor_groups[]">' +

			'</div>' +
			'</td>' +
			'</tr>';
		$("#suppressorsTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveProvocative", function() {
		$(this).closest("tr").remove();
	});

	// Add row button click event
	$("#addRowBtn").click(function() {
		var newRow =
			"<tr>" +
			'<td><input type="text" class="form-control" placeholder="" id="" name="provocative_case[]"></td>' +
			'<td><button class="removeBtn">Remove</button></td>' +
			"</tr>";
		$("#myTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", ".removeBtn", function() {
		$(this).closest("tr").remove();
	});
});
</script>

<script>
$(document).ready(function() {
	$('.AddmoreProvocative').on('click', function(e) {
		e.preventDefault();
		var $rows = $('table.provocative  tr');
		var lastActiveIndex = $rows.filter('.active:last').index();
		$rows.filter(':lt(' + (lastActiveIndex + 2) + ')').addClass('active');

		// hide the button when all elements visible
		$(this).toggle($rows.filter(':hidden').length !== 0);
	});
	$('.AddmoreTeam').on('click', function(e) {
		e.preventDefault();
		var $rows = $('table.Team  tr');
		var lastActiveIndex = $rows.filter('.active:last').index();
		$rows.filter(':lt(' + (lastActiveIndex + 2) + ')').addClass('active');

		// hide the button when all elements visible
		$(this).toggle($rows.filter(':hidden').length !== 0);
	});

});
</script>
<script>
$(function() {
	$('#description').summernote();
	$('#original_source').summernote()


});
</script>

<script>
$(function() {
	//Initialize Select2 Elements
	$('.select2').select2({
		placeholder: "Select a state",
		allowClear: true
	})

	//Initialize Select2 Elements
	$('.select2bs4').select2({
		theme: 'bootstrap4'
	})

	//Datemask yyyy-mm-dd
	$('#datemask').inputmask('yyyy-mm-dd', {
		'placeholder': 'yyyy-mm-dd'
	})
	//Datemask2 yyyy-mm-dd
	$('#datemask2').inputmask('yyyy-mm-dd', {
		'placeholder': 'yyyy-mm-dd'
	})
	//Money Euro
	$('[data-mask]').inputmask()

	//Date picker
	$('#reservationdate').datetimepicker({
		format: 'yyyy-M-D'
	});
	//Date picker
	$('#reservationdate1').datetimepicker({
		format: 'yyyy-M-D'
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
			format: 'yyyy-mm-dd hh:mm A'
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