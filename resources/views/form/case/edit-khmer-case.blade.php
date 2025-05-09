@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">កែសម្រួលព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)</li>
@endsection
@section('sidebar')

@include('sidebar.sidebarCaseList')
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
									<input class="form-control " id="kh_case_id" name="kh_case_id"
										value="{{$caseKH->id}}" placeholder="" hidden>
									<input class="form-control " id="case_id" name="case_id"
										value="{{$caseKH->case_id}}" placeholder="" hidden>
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
																id="title" name="title" placeholder="input"
																value="{{$caseKH->title}}">
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
										<!--================ new designing =============================-->
										<!----------------- កាលបរិច្ឆេទកើតហេតុ ----------------->
										<div class="col-md-12">
											<div class="card-header">
												<h2 class="card-title label1" style="font-weight: 700;">កាលបរិច្ឆេទកើតហេតុ</h2>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-3">
														<label class='label1' style="font-weight: 200;"
															>កាលបរិច្ឆេទចុះផ្សាយ</label>
														<div class="input-group date" id="reservationdate"
															data-target-input="nearest">
															<input type="text"
																class="form-control datetimepicker-input "
																data-target="#reservationdate" id="released_date"
																name="released_date"
																value="{{$caseKH->released_date}}" />
															<div class="input-group-append"
																data-target="#reservationdate"
																data-toggle="datetimepicker">
																<div class="input-group-text"><i
																		class="fa fa-calendar"></i></div>
															</div>
														</div>
													</div>
													<div class="col-sm-3">
														<label class='label1'
															style="font-weight: 200;">កាលបរិច្ឆេទជាក់ស្តែង</label>
														<div class="input-group date" id="reservationdate1"
															data-target-input="nearest">
															<input type="text"
																class="form-control datetimepicker-input "
																data-target="#reservationdate1" id="actual_date"
																name="actual_date" value="{{$caseKH->actual_date}}" />
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
										<!------------------ ការខាតបង់ ------------------->
										<div class="col-md-12">
											<div class="card-header">
												<h3 class="card-title label1" style="font-weight: 700;">ការខាតបង់</h3>
											</div>
											<div class="card-body">
												<div class="row">
													
													<div class="col-sm-3">
														<label class='label1'
															style="font-weight: 200;">ចំនួនស្លាប់</label>
														<input type="number" class="form-control " id="death"
															name="death" placeholder="" value="{{$caseKH->death}}">
													</div>
													<div class="col-sm-3">
														<label class='label1'
															style="font-weight: 200;">ចំនួនរបួស</label>
														<input type="number" class="form-control " id="injure"
															name="injure" placeholder="" value="{{$caseKH->injure}}">
													</div>
													<div class="col-sm-3">
														<label class='label1'
															style="font-weight: 200;">ចំនួនឃុំខ្លួន</label>
														<input type="number" class="form-control " id="detention"
															name="detention" placeholder=""
															value="{{$caseKH->detention}}">
													</div>
													<div class="col-sm-3">
														<label class='label1'
															style="font-weight: 200;">ផ្លាស់ទីលំនៅ</label>
														<input type="number" class="form-control " id="relocate"
															name="relocate" placeholder=""
															value="{{$caseKH->relocate}}">
													</div>
													<div class="col-sm-3">
														<label class='label1'
															style="font-weight: 200;">ចំណាកស្រុក</label>
														<input type="number" class="form-control " id="migration"
															name="migration" placeholder=""
															value="{{$caseKH->migration}}">
													</div>
												</div>
											</div>
										</div>
										<!----------- ករណីបង្ក -------------->
										<div class="col-md-12">
											<div class="card-header">
												<h3 class="card-title label1" style="font-weight: 700;">ករណីបង្ក</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-3">
														<label class="label1" style="font-weight: 200;">សកម្មភាព</label>
														<select class="custom-select rounded-0 " id="activities"
															name="activities">
															<option> </option>
															@foreach($actions as $action)
															<option
																{{$action->name == $caseKH->activities  ? 'selected' : ''}}>
																{{$action->name}}</option>
															@endforeach
														</select>
													</div>
													<div class="col-sm-3">
														<label class="label1" style="font-weight: 200;">ករណីបង្ក</label>
														<input type="text" class="form-control " id="causing_case"
															name="causing_case" placeholder=""
															value="{{$caseKH->causing_case}}">

													</div>
													<div class="col-sm-3">
														<label class="label1" style="font-weight: 200;">ប្រទេស</label>
														<div class="form-group">
															<select class="select2" data-placeholder="" id="country"
																name="country" style="width: 100%; height: 40%;">
																<option> </option>
																@foreach($countries as $country)
																<option value="{{$country->name_eng}}"
																	{{$country->name_eng == $caseKH->country  ? 'selected' : ''}}>
																	{{$country->name_eng}}
																</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-sm-3">
														<label class="label1" style="font-weight: 200;">ខេត្ត</label>
														<input type="text" class="form-control " id="province_city"
															name="province_city" placeholder=""
															value="{{$caseKH->province_city}}">
													</div>
													<div class="col-sm-3">
														<label class="label1" style="font-weight: 200;">តំបន់</label>
														<input type="text" class="form-control " id="area" name="area"
															placeholder="" value="{{$caseKH->area}}">
													</div>
													<div class="col-sm-3">
														<label class="label1"
															style="font-weight: 200;">ក្រុមបង្កហេតុ/អ្នកពាក់ព័ន្ធ</label>
														<input type="text" class="form-control " id="provocative_group"
															name="provocative_group" placeholder=""
															value="{{$caseKH->provocative_group}}">
													</div>
													<div class="col-sm-3">
														<label class="label1"
															style="font-weight: 200;">ក្រុមរងគ្រោះ</label>
														<input type="text" class="form-control " id="victim"
															name="victim" placeholder="" value="{{$caseKH->victim}}">
													</div>
													<div class="col-sm-3">
														<label class="label1"
															style="font-weight: 200;">ឈ្មោះជនបង្ក</label>
														<input type="text" class="form-control " id="perpetrator_name"
															name="perpetrator_name" placeholder=""
															value="{{$caseKH->perpetrator_name}}">
													</div>
													<div class="col-sm-3">
														<label class="label1"
															style="font-weight: 200;">ឈ្មោះជនរងគ្រោះ</label>
														<input type="text" class="form-control " id="victim_name"
															name="victim_name" placeholder=""
															value="{{$caseKH->victim_name}}">
													</div>
												</div>
											</div>
										</div>
										<!----------- ករណីបង្ក្រាប -------------->
										<div class="col-md-12">
											<div class="card-header">
												<h3 class="card-title label1" style="font-weight: 700;">ករណីបង្ក្រាប
												</h3>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-sm-3">
														<label class="label1"
															style="font-weight: 200;">ករណីបង្កហេតុ</label>
														<input type="text" class="form-control " id="provocative_case"
															name="provocative_case" placeholder=""
															value="{{$caseKH->provocative_case}}">
													</div>
													<div class="col-sm-3">
													</div>
													<div class="col-sm-3">
													</div>
													<div class="col-sm-3">
													</div>

													<!----------------អ្នកបង្រ្កាប-------------->
													<div class="col-sm-6">
														<div class="card-header"
															style="padding-left: 0px; padding-top: 30px;">
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
																	@if(!empty($suppressors))
																		@foreach($suppressors as $suppressor)
																			<tr>
																				<td>
																					<div class="input-group">
																						<button type="button"
																							class="btn btn-danger btn-xs"
																							id="btnRemoveProvocative">
																							<i class="fas fa-minus"
																								aria-hidden="true"></i>
																						</button>
																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">អង្គភាព</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="suppressors_orgs"
																							name="suppressors_orgs[]"
																							value="{{$suppressor['suppressors_org']}}">

																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">បុគ្គល/ក្រុម</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="suppressor_groups"
																							name="suppressor_groups[]"
																							value="{{$suppressor['suppressor_group']}}">
																					</div>
																				</td>
																			</tr>
																		@endforeach
																	@else
																		<tr>
																			<td>
																				<div class="input-group">
																					<button type="button"
																						class="btn btn-danger btn-xs"
																						id="btnRemoveProvocative">
																						<i class="fas fa-minus"
																							aria-hidden="true"></i>
																					</button>
																					<div class="input-group-prepend">
																						<span
																							class="input-group-text">អង្គភាព</span>
																					</div>
																					<input type="text"
																						class="form-control"
																						placeholder=""
																						id="suppressors_orgs"
																						name="suppressors_orgs[]">

																					<div class="input-group-prepend">
																						<span
																							class="input-group-text">បុគ្គល/ក្រុម</span>
																					</div>
																					<input type="text"
																						class="form-control"
																						placeholder=""
																						id="suppressor_groups"
																						name="suppressor_groups[]">
																				</div>
																			</td>
																		</tr>
																	@endif
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<!------------------អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ------------------>
													<div class="col-sm-6">
														<div class="card-header"
															style="padding-left: 0px; padding-top: 30px;">
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
																		@if(!empty($attackers))
																			@foreach($attackers as $attacker)
																				<tr>
																					<td>
																						<div class="input-group">
																							<button type="button"
																								class="btn btn-danger btn-xs"
																								id="btnRemoveAttacker">
																								<i class="fas fa-minus"
																									aria-hidden="true"></i>
																							</button>
																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">អង្គភាព</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder="" id="attack_orgs"
																								name="attack_orgs[]"
																								value="{{$attacker['attack_org']}}">

																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">បុគ្គល/ក្រុម</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="attack_groups"
																								name="attack_groups[]"
																								value="{{$attacker['attack_group']}}">
																						</div>
																					</td>
																				</tr>
																			@endforeach
																		@else
																			<tr>
																				<td>
																					<div class="input-group">
																						<button type="button"
																							class="btn btn-danger btn-xs"
																							id="btnRemoveAttacker">
																							<i class="fas fa-minus"
																								aria-hidden="true"></i>
																						</button>
																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">អង្គភាព</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder="" id="attack_orgs"
																							name="attack_orgs[]">

																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">បុគ្គល/ក្រុម</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="attack_groups"
																							name="attack_groups[]">


																					</div>

																				</td>

																			</tr>
																		@endif
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<!------------------ អ្នកដែលត្រូវបានបង្ក្រាប ------------------>
													<div class="col-sm-6">
														<div class="card-header"
															style="padding-left: 0px; padding-top: 30px;">
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
																		@if(!empty($suppresseds))
																			@foreach($suppresseds as $suppressed)
																				<tr>
																					<td>
																						<div class="input-group">
																							<button type="button"
																								class="btn btn-danger btn-xs"
																								id="btnRemoveSuppressed">
																								<i class="fas fa-minus"
																									aria-hidden="true"></i>
																							</button>
																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">អង្គភាព</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="suppressed_orgs"
																								name="suppressed_orgs[]"
																								value="{{$suppressed['suppressed_org']}}">

																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">បុគ្គល/ក្រុម</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="suppressed_groups"
																								name="suppressed_groups[]"
																								value="{{$suppressed['suppressed_group']}}">
																						</div>
																					</td>
																				</tr>
																			@endforeach
																		@else
																			<tr>
																				<td>
																					<div class="input-group">
																						<button type="button"
																							class="btn btn-danger btn-xs"
																							id="btnRemoveSuppressed">
																							<i class="fas fa-minus"
																								aria-hidden="true"></i>
																						</button>
																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">អង្គភាព</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="suppressed_orgs"
																							name="suppressed_orgs[]">

																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">បុគ្គល/ក្រុម</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="suppressed_groups"
																							name="suppressed_groups[]">


																					</div>
																				</td>
																			</tr>
																		@endif
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<!------------------ អ្នករងគ្រោះ ------------------>
													<div class="col-sm-6">
														<div class="card-header"
															style="padding-left: 0px; padding-top: 30px;">
															<h3 class="card-title label1" style="padding-right: 10px;">
																<button type="button" class="btn btn-success btn-xs"
																	id="btnAddMoreVictim">
																	<i class="fas fa-plus" aria-hidden="true"></i>
																</button>
																អ្នករងគ្រោះ
															</h3>
														</div>
														<div class="row">
															<div class="col-sm-12">
																<table id="VictimTable" style="width:100%">
																	<tbody>
																	@if(!empty($victims))
																			@foreach($victims as $victim)
																				<tr>
																					<td>
																						<div class="input-group">
																							<button type="button"
																								class="btn btn-danger btn-xs"
																								id="btnRemoveVictim">
																								<i class="fas fa-minus"
																									aria-hidden="true"></i>
																							</button>
																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">អង្គភាព</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder="" id="victim_orgs"
																								name="victim_orgs[]"
																								value="{{$victim['victim_org']}}">

																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">បុគ្គល/ក្រុម</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="victim_groups"
																								name="victim_groups[]"
																								value="{{$victim['victim_group']}}">
																						</div>
																					</td>
																				</tr>
																			@endforeach
																		@else
																			<tr>
																				<td>
																					<div class="input-group">
																						<button type="button"
																							class="btn btn-danger btn-xs"
																							id="btnRemoveVictim">
																							<i class="fas fa-minus"
																								aria-hidden="true"></i>
																						</button>
																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">អង្គភាព</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder="" id="victim_orgs"
																							name="victim_orgs[]">

																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">បុគ្គល/ក្រុម</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="victim_groups"
																							name="victim_groups[]">


																					</div>

																				</td>

																			</tr>
																		@endif
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<!------------------ ទីតាំងបង្ក្រាប ------------------>
													<div class="col-sm-12">
														<div class="card-header"
															style="padding-left: 0px; padding-top: 30px;">
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
																	@if(!empty($crackdowns))
																			@foreach($crackdowns as $crackdown)
																				<tr>
																					<td>
																						<div class="input-group">
																							<button type="button"
																								class="btn btn-danger btn-xs"
																								id="btnRemoveCrackdownLocation">
																								<i class="fas fa-minus"
																									aria-hidden="true"></i>
																							</button>
																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">ប្រទេស</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="crackdown_countries"
																								name="crackdown_countries[]"
																								value="{{$crackdown['crackdown_country']}}">

																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">ខេត្ត/ក្រុង</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="crackdown_provinces"
																								name="crackdown_provinces[]"
																								value="{{$crackdown['crackdown_province']}}">

																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">តំបន់</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="crackdown_areas"
																								name="crackdown_areas[]"
																								value="{{$crackdown['crackdown_area']}}">
																						</div>
																					</td>
																				</tr>
																			@endforeach
																		@else
																			<tr>
																				<td>
																					<div class="input-group">
																						<button type="button"
																							class="btn btn-danger btn-xs"
																							id="btnRemoveCrackdownLocation">
																							<i class="fas fa-minus"
																								aria-hidden="true"></i>
																						</button>
																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">ប្រទេស</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="crackdown_countries"
																							name="crackdown_countries[]">

																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">ខេត្ត/ក្រុង</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="crackdown_provinces"
																							name="crackdown_provinces[]">

																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">តំបន់</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="crackdown_areas"
																							name="crackdown_areas[]">


																					</div>

																				</td>

																			</tr>
																		@endif
																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<!------------------ ទីតាំងវាយប្រហារ ------------------>
													<div class="col-sm-12">
														<div class="card-header"
															style="padding-left: 0px; padding-top: 30px;">
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
																		@if(!empty($attackeds))
																			@foreach($attackeds as $attacked)
																				<tr>
																					<td>
																						<div class="input-group">
																							<button type="button"
																								class="btn btn-danger btn-xs"
																								id="btnRemoveAttackLocation">
																								<i class="fas fa-minus"
																									aria-hidden="true"></i>
																							</button>
																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">ប្រទេស</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="attacked_countries"
																								name="attacked_countries[]"
																								value="{{$attacked['attacked_country']}}">

																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">ខេត្ត/ក្រុង</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="attacked_provinces"
																								name="attacked_provinces[]"
																								value="{{$attacked['attacked_province']}}">

																							<div class="input-group-prepend">
																								<span
																									class="input-group-text">តំបន់</span>
																							</div>
																							<input type="text"
																								class="form-control"
																								placeholder=""
																								id="attacked_areas"
																								name="attacked_areas[]"
																								value="{{$attacked['attacked_area']}}">
																						</div>
																					</td>
																				</tr>
																			@endforeach
																		@else
																			<tr>
																				<td>
																					<div class="input-group">
																						<button type="button"
																							class="btn btn-danger btn-xs"
																							id="btnRemoveAttackLocation">
																							<i class="fas fa-minus"
																								aria-hidden="true"></i>
																						</button>
																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">ប្រទេស</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="attacked_countries"
																							name="attacked_countries[]">

																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">ខេត្ត/ក្រុង</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="attacked_provinces"
																							name="attacked_provinces[]">

																						<div class="input-group-prepend">
																							<span
																								class="input-group-text">តំបន់</span>
																						</div>
																						<input type="text"
																							class="form-control"
																							placeholder=""
																							id="attacked_areas"
																							name="attacked_areas[]">


																					</div>

																				</td>

																			</tr>
																		@endif
																	</tbody>
																</table>
															</div>
														</div>
													</div>

													<div class="col-sm-6">
														<div class="form-group" style="padding-top: 30px;">
															<label>សម្ភារៈផ្សេងទៀត</label>
															<textarea class="form-control" rows="3"
																name="other_material"
																placeholder="">{{$caseKH->other_material}}</textarea>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group" style="padding-top: 30px;">
															<label>ការខាតបង់ផ្សេងទៀត</label>
															<textarea class="form-control" rows="3" name="other_losses"
																placeholder="">{{$caseKH->other_losses}}</textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--================ end new designing =============================-->
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