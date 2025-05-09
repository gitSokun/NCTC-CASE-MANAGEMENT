@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">បង្កើតព្រឹត្តិការណ៍(ទម្រង់មូលដ្ឋាន)</li>
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
	<form class="form-horizontal" enctype="multipart/form-data" id="newcase" method="POST"
		action="{{ route('case-information-update') }}">
		{{ csrf_field() }}
		<div class="card">
			<input class="form-control " id="id" name="id" value="{{$case->id}}" placeholder="" hidden>
			<div class="card-header">
				<div class="btn-group" style="float: right;">
					<button type="button" class="btn btn-danger" onclick="window.location='{{ route('CaseList')}}'">
						<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
					</button>
					<button type="submit" class="btn btn-success toastrDefaultSuccess">
						<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុក
					</button>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-6">
						<label class='label1' style="font-weight: 200;">លេខសំគាល់ ព្រឹត្តិការណ៍</label>
						<div class="input-group ">
							<input type="text" class="form-control" id="caseNumber" value="{{$case->case_number}}"
								readonly />
						</div>
					</div>
					<div class="col-sm-6">
						<label class='label1' style="font-weight: 200;">លេខសំគាល់ ព្រឹត្តិការណ៍​
							ពាក់ព័ន្ធ</label>
						<div class="input-group ">
							<input type="text" class="form-control" id="related_case_number" name="related_case_number"
								value="{{$case->related_case_number}}" />
						</div>
					</div>
					<div class="col-12">
						<div style="padding-top: 10px;">
							<h3 class="card-title label1" style="font-weight: 700;">អត្ថបទ</h3>
							<hr style="margin-top: 1.5rem;">
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label class="label1" style="font-weight: 200;color:red;">* ចំណងជើង
							</label>
							<input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
								name="title" placeholder="" value="{{$case->title}}">
							@if($errors->has('title'))
							<label for="inputSkills" class="col-sm-12 col-form-label "
								style="color:red;">{{ $errors->first('title') }}</label>
							@endif
						</div>
					</div>
					<div class="col-12">
						<label class="label1" style="font-weight: 200;color:red;">* ខ្លឹមសារដើម
							(មានទាំង link ដើម)</label>
						<textarea id="original_source" name="original_source"
							class="@error('original_source') is-invalid @enderror">{{$case->original_source}}</textarea>
						@if($errors->has('original_source'))
						<label for="original_source" class="col-sm-12 col-form-label "
							style="color:red;">{{ $errors->first('original_source') }}</label>
						@endif
					</div>
					<div class="col-12">
						<div style="padding-top: 10px;">
							<h2 class="card-title label1" style="font-weight: bold;">កាលបរិច្ឆេទកើតហេតុ</h2>
							<hr style="margin-top: 1.5rem;">
						</div>
					</div>
					<div class="col-6">
						<label class='label1' style="font-weight: 200;" s>កាលបរិច្ឆេទចុះផ្សាយ</label>
						<div class="input-group date" id="reservationdate" data-target-input="nearest">
							<input type="text" class="form-control datetimepicker-input " data-target="#reservationdate"
								id="released_date" name="released_date" value="{{$case->released_date}}" />

							<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
					</div>
					<div class="col-6">
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
					<div class="col-6">
						<label class="label1" style="font-weight: 200;">ប្រទេស</label>
						<div class="form-group">
							<select class="select2" data-placeholder="" id="country" name="country"
								style="width: 100%; height: 40%;">
								<option></option>
								@foreach($countries as $country)
								<option value="{{$country->name_eng}}"
									{{$country->name_eng == $case->country  ? 'selected' : ''}}>
									{{$country->name_eng}}
								</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-6">
						<label class="label1" style="font-weight: 200;">ខេត្ត</label>
						<input type="text" class="form-control " id="province_city" name="province_city" placeholder=""
							value="{{$case->province_city}}">
					</div>
					<div class="col-6">
						<label class="label1" style="font-weight: 200;">តំបន់</label>
						<input type="text" class="form-control " id="area" name="area" placeholder=""
							value="{{$case->area}}">
					</div>
					<div class="col-12">
						<div style="padding-top: 20px;">
							<h2 class="card-title label1" style="font-weight: bold;">ការខាតបង់</h2>
							<hr style="margin-top: 1.5rem;">
						</div>
					</div>
					<div class="col-6">
						<label class='label1' style="font-weight: 200;">ចំនួនស្លាប់</label>
						<input type="number" class="form-control " id="death" name="death" placeholder=""
							value="{{$case->death}}">
					</div>
					<div class="col-6">
						<label class='label1' style="font-weight: 200;">ចំនួនរបួស</label>
						<input type="number" class="form-control " id="injure" name="injure" placeholder=""
							value="{{$case->injure}}">
					</div>
					<div class="col-6">
						<label class='label1' style="font-weight: 200;">ចំនួនឃុំខ្លួន</label>
						<input type="number" class="form-control " id="detention" name="detention"
							value="{{$case->detention}}">
					</div>
					<div class="col-6">
						<label class='label1' style="font-weight: 200;">ផ្លាស់ទីលំនៅ</label>
						<input type="number" class="form-control " id="relocate" name="relocate"
							value="{{$case->relocate}}">
					</div>
					<div class="col-6">
						<label class='label1' style="font-weight: 200;">ចំណាកស្រុក</label>
						<input type="number" class="form-control " id="migration" name="migration"
							value="{{$case->migration}}">
					</div>
				</div>
				<div class="row">
					<!--=========div សកម្មភាព ផ្សេងៗ ========-->
					<div class="col-6">
						<label class="label1" style="font-weight: 200;">សកម្មភាព</label>
						<select class="custom-select rounded-0 " id="activities" name="activities" placeholder="">
							<option value="show_none"></option>
							<option value="other_case" {{$case->activities == 'other_case'  ? 'selected' : ''}}>
								ផ្សេងៗ</option>
							<option value="show_causing_case"
								{{$case->activities == 'show_causing_case'  ? 'selected' : ''}}>ការវាយប្រហារ
							</option>
							<option value="show_crackdown_case"
								{{$case->activities == 'show_crackdown_case'  ? 'selected' : ''}}>ការបង្ក្រាប
							</option>
						</select>
					</div>
					<div class="col-6">
						<label class="label1" style="font-weight: 200;">ករណីបង្ក</label>
						<input type="text" class="form-control " id="causing_case" name="causing_case" placeholder=""
							value="{{$case->causing_case}}">
					</div>
					<!--=========div សកម្មភាព ផ្សេងៗ ========-->
					
					<div class="col-md-12" id="other_activities_div" 
					style="{{ $case->activities == 'other_case' ? 'display: block;' : 'display: none;'}}">
						<div class="form-group" style="padding-top: 5px;">
							<label>សកម្មភាព ផ្សេងៗ</label>
							<textarea class="form-control" rows="3" name="other_activities"
								placeholder="">
								@if($case->other_activities)
								{{$case->other_activities}}
								@endif
								</textarea>
						</div>
					</div>
					
					
					<!--=========div ការវាយប្រហារ ========-->
					<div class="col-md-12" id="causing_case_div" style="{{ $case->activities == 'show_causing_case' ? 'display: block;' : 'display: none;' }}" >
						<!------------------អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ------------------>
						<div style="padding-top: 10px;">
							<h4 class="card-title label1" style="padding-right: 10px;">
								<button type="button" class="btn btn-success btn-xs" id="btnAddMoreAttacker">
									<i class="fas fa-plus" aria-hidden="true"></i>
								</button>
								<span style="font-weight: 200; font-size: 15px;"> អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ
								</span>
							</h4>
							<table id="attackerTable" style="width:100%">
								<tbody>
									@if(!empty($attackers))
									@foreach($attackers as $attacker)
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveAttacker">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
												</div>
												<input type="text" class="form-control" placeholder="" id="attack_orgs"
													name="attack_orgs[]" 
													value="{{ data_get($attacker, 'attack_org', '') }}"
													>

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ក្រុម</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attack_groups" name="attack_groups[]"
													value="{{ data_get($attacker, 'attack_group', '') }}">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attack_individuals" name="attack_individuals[]"
													value="{{ data_get($attacker, 'attack_indiv', '') }}">
											</div>
										</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveAttacker">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
												</div>
												<input type="text" class="form-control" placeholder="" id="attack_orgs"
													name="attack_orgs[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ក្រុម</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attack_groups" name="attack_groups[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attack_individuals" name="attack_individuals[]">
											</div>
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
						<!------------------ អ្នករងគ្រោះ ------------------>
						<div style="padding-top: 10px;">
							<h4 class="card-title label1" style="padding-right: 10px;">
								<button type="button" class="btn btn-success btn-xs" id="btnAddMoreVictim">
									<i class="fas fa-plus" aria-hidden="true"></i>
								</button>
								<span style="font-weight: 200; font-size: 15px;"> អ្នករងគ្រោះ</span>
							</h4>
							<table id="VictimTable" style="width:100%">
								<tbody>
									@if(!empty($victims))
									@foreach($victims as $victim)
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveVictim">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
												</div>
												<input type="text" class="form-control" placeholder="" id="victim_orgs"
													name="victim_orgs[]" 
													value="{{ data_get($victim, 'victim_org', '') }}"
													>

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ក្រុម</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="victim_groups" name="victim_groups[]"
													value="{{ data_get($victim, 'victim_group', '') }}"
													>

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="victim_individuals" name="victim_individuals[]"
													value="{{ data_get($victim, 'victim_indiv', '') }}"
													>

											</div>
										</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveVictim">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
												</div>
												<input type="text" class="form-control" placeholder="" id="victim_orgs"
													name="victim_orgs[]">
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ក្រុម</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="victim_groups" name="victim_groups[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="victim_individuals" name="victim_individuals[]">
											</div>
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
						<!------------------ ទីតាំងវាយប្រហារ ------------------>
						<div style="padding-top: 10px;">
							<h4 class="card-title label1" style="padding-right: 10px;">
								<button type="button" class="btn btn-success btn-xs" id="btnAddMoreAttackLocation">
									<i class="fas fa-plus" aria-hidden="true"></i>
								</button> <span style="font-weight: 200; font-size: 15px;">ទីតាំងវាយប្រហារ</span>
							</h4>
							<table id="AttackLocationTable" style="width:100%">
								<tbody>
									@if(!empty($attackeds))
									@foreach($attackeds as $attacked)
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveAttackLocation">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ប្រទេស</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attacked_countries" name="attacked_countries[]"
													value="{{ data_get($attacked, 'attacked_country', '') }}"
													>

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ខេត្ត/ក្រុង</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attacked_provinces" name="attacked_provinces[]"
													value="{{ data_get($attacked, 'attacked_province', '') }}"
													>

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">តំបន់</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attacked_areas" name="attacked_areas[]"
													value="{{ data_get($attacked, 'attacked_area', '') }}"
													>
											</div>
										</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveAttackLocation">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ប្រទេស</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attacked_countries" name="attacked_countries[]">
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ខេត្ត/ក្រុង</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attacked_provinces" name="attacked_provinces[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">តំបន់</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="attacked_areas" name="attacked_areas[]">
											</div>
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					
					<!--=========div ករណីបង្ក្រាប ========-->
					<div class="col-md-12" id="crackdown_case_div" 
					style="{{ $case->activities == 'show_crackdown_case' ? 'display: block;' : 'display: none;' }}" >
						<!----------------អ្នកបង្រ្កាប-------------->
						<div style="padding-top: 10px;">
							<h4 class="card-title label1" style="padding-right: 10px;">
								<button type="button" class="btn btn-success btn-xs" id="btnAddMoreProvocative">
									<i class="fas fa-plus" aria-hidden="true"></i>
								</button> <span style="font-weight: 200; font-size: 15px;"> អ្នកបង្រ្កាប
								</span>
							</h4>
							<table id="suppressorsTable" style="width:100%">
								<tbody>
									@if(!empty($suppressors))
									@foreach($suppressors as $suppressor)
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveProvocative">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressors_orgs" name="suppressors_orgs[]"
													value="{{ data_get($suppressor, 'suppressors_org', '') }}"
													>

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ក្រុម</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressor_groups" name="suppressor_groups[]"
													value="{{ data_get($suppressor, 'suppressor_group', '') }}"
													>

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressor_individuals" name="suppressor_individuals[]"
													value="{{ data_get($suppressor, 'suppressor_indiv', '') }}"
													>
											</div>
										</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveProvocative">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressors_orgs" name="suppressors_orgs[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ក្រុម</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressor_groups" name="suppressor_groups[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressor_individuals" name="suppressor_individuals[]">
											</div>
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
						<!------------------ អ្នកដែលត្រូវបានបង្ក្រាប ------------------>
						<div style="padding-top: 10px;">
							<h4 class="card-title label1" style="padding-right: 10px;">
								<button type="button" class="btn btn-success btn-xs" id="btnAddMoreSuppressed">
									<i class="fas fa-plus" aria-hidden="true"></i>
								</button> <span style="font-weight: 200; font-size: 15px;">
									អ្នកដែលត្រូវបានបង្ក្រាប</span>
							</h4>
							<table id="SuppressedTable" style="width:100%">
								<tbody>
									@if(!empty($suppresseds))
									@foreach($suppresseds as $suppresse)
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveSuppressed">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressed_orgs" name="suppressed_orgs[]"
													value="{{ data_get($suppresse, 'suppressed_org', '') }}"
													>

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ក្រុម</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressed_groups" name="suppressed_groups[]"
													value="{{ data_get($suppresse, 'suppressed_group', '') }}"
													>

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressed_individuals" name="suppressed_individuals[]"
													value="{{ data_get($suppresse, 'suppressed_indiv', '') }}"
													>

											</div>
										</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveSuppressed">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressed_orgs" name="suppressed_orgs[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ក្រុម</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressed_groups" name="suppressed_groups[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="suppressed_individuals" name="suppressed_individuals[]">

											</div>
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
						<!------------------ ទីតាំងបង្ក្រាប ------------------>
						<div style="padding-top: 10px;">
							<h4 class="card-title label1" style="padding-right: 10px;">
								<button type="button" class="btn btn-success btn-xs" id="btnAddMoreCrackdownLocation">
									<i class="fas fa-plus" aria-hidden="true"></i>
								</button>
								<span style="font-weight: 200; font-size: 15px;">
									ទីតាំងបង្ក្រាប
								</span>
							</h4>
							<table id="CrackdownLocationTable" style="width:100%">
								<tbody>
									@if(!empty($crackdowns))
									@foreach($crackdowns as $crackdown)
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveCrackdownLocation">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ប្រទេស</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="crackdown_countries" name="crackdown_countries[]"
													value="{{$crackdown['crackdown_country']}}">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ខេត្ត/ក្រុង</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="crackdown_provinces" name="crackdown_provinces[]"
													value="{{$crackdown['crackdown_province']}}">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">តំបន់</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="crackdown_areas" name="crackdown_areas[]"
													value="{{$crackdown['crackdown_area']}}">
											</div>
										</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td>
											<div class="input-group">
												<button type="button" class="btn btn-danger btn-xs"
													id="btnRemoveCrackdownLocation">
													<i class="fas fa-minus" aria-hidden="true"></i>
												</button>
												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ប្រទេស</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="crackdown_countries" name="crackdown_countries[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">ខេត្ត/ក្រុង</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="crackdown_provinces" name="crackdown_provinces[]">

												<div class="input-group-prepend">
													<span class="input-group-text"
														style="font-weight: 200; font-size: 15px;">តំបន់</span>
												</div>
												<input type="text" class="form-control" placeholder=""
													id="crackdown_areas" name="crackdown_areas[]">
											</div>
										</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<!--==================================-->
					<div class="col-sm-6">
						<div class="form-group" style="padding-top: 5px;">
							<label>សម្ភារៈផ្សេងទៀត</label>
							<textarea class="form-control" rows="3" name="other_material"
								placeholder="">{{$case->other_material}}</textarea>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group" style="padding-top: 5px;">
							<label>ការខាតបង់ផ្សេងទៀត</label>
							<textarea class="form-control" rows="3" name="other_losses"
								placeholder="">{{$case->other_losses}}</textarea>
						</div>
					</div>
					<div class="col-12">
						<div style="padding-top: 20px;">
							<h2 class="card-title label1" style="font-weight: bold;">ការបង្ហោះឯកសារពាក់ព័ន្ធ(Attach
								file)</h2>
							<hr style="margin-top: 1.5rem;">
						</div>
					</div>
					<div class="col-md-12">
						<div class="card card-default">
							<div class="card-body">
								<input type="file" class="form-control" name="photos[]" multiple />
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div style="padding-top: 20px;">
							<h2 class="card-title label1" style="font-weight: bold;">បញ្ជីឯកសារ</h2>
							<hr style="margin-top: 1.5rem;">
						</div>
					</div>
					<div class="col-12">
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
										<span
											style="display: inline-block; vertical-align: middle; line-height: normal;"
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
										<input class="form-control " id="id" name="id"
											value="{{Crypt::encrypt($case->id)}}" placeholder="" hidden>
										<input class="form-control " id="case_upload_id" name="case_upload_id"
											value="{{Crypt::encrypt($file->id)}}" placeholder="" hidden>
										<button type="submit" class="btn btn-danger"
											onclick="return confirm('តើអ្នកប្រាកដថាចង់លុបឯកសារ ?')">
											<i class="fas fa-trash" aria-hidden="true"></i> លុបឯកសារ
										</button>
									</form>
								</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<div class="btn-group" style="float: right;">
					<button type="button" class="btn btn-danger" onclick="window.location='{{route('CaseList')}}'">
						<i class="fas fa-arrow-circle-left" aria-hidden="true"></i> ត្រលប់ក្រោយ
					</button>
					<button type="submit" class="btn btn-success toastrDefaultSuccess">
						<i class="fas fa-save" aria-hidden="true"></i> រក្សាទុក
					</button>
				</div>
			</div>
		</div>

	</form>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
	//----------------- even of select box ------------
	$('#activities').change(function() {
		var value = $(this).val();

		if (value == 'other_case') {
			$('#other_activities_div').show();
			$('#causing_case_div').hide();
			$('#crackdown_case_div').hide();
		}

		if (value == 'show_none') {
			$('#other_activities_div').hide();
			$('#causing_case_div').hide();
			$('#crackdown_case_div').hide();
		}

		if (value === 'show_causing_case') {
			$('#other_activities_div').hide();
			$('#causing_case_div').show();
			$('#crackdown_case_div').hide();
		}

		if (value === 'show_crackdown_case') {
			$('#other_activities_div').hide();
			$('#causing_case_div').hide();
			$('#crackdown_case_div').show();
		}
	});
	//--------------------ការវាយប្រហារ----------------
	//<!------------------អ្នកវាយប្រហារ/អ្នកបង្ក/អ្នកពាក់ព័ន្ធ------------------>
	$("#btnAddMoreAttacker").click(function() {
		var newRow = `
			<tr>
				<td>
					<div class="input-group">
						<button type="button" class="btn btn-danger btn-xs" id="btnRemoveAttacker">
							<i class="fas fa-minus" aria-hidden="true"></i>
						</button>
						<div class="input-group-prepend">
							<span class="input-group-text" style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
						</div>
						<input type="text" class="form-control" placeholder="" id="attack_orgs" name="attack_orgs[]">
						<div class="input-group-prepend">
							<span class="input-group-text" style="font-weight: 200; font-size: 15px;">ក្រុម</span>
						</div>
						<input type="text" class="form-control" placeholder="" id="attack_groups" name="attack_groups[]">
						<div class="input-group-prepend">
							<span class="input-group-text" style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
						</div>
						<input type="text" class="form-control" placeholder="" id="attack_individuals" name="attack_individuals[]">
					</div>
				</td>
			</tr>`;
		$("#attackerTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveAttacker", function() {
		$(this).closest("tr").remove();
	});
	//<!------------------ អ្នករងគ្រោះ ------------------>
	$("#btnAddMoreVictim").click(function() {
		var newRow = `
		<tr>
			<td>
				<div class="input-group">
					<button type="button" class="btn btn-danger btn-xs" id="btnRemoveVictim">
						<i class="fas fa-minus" aria-hidden="true"></i>
					</button>
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
					</div>
					<input type="text" class="form-control" placeholder="" id="victim_orgs" name="victim_orgs[]">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight: 200; font-size: 15px;">ក្រុម</span>
					</div>
					<input type="text" class="form-control" placeholder="" id="victim_groups" name="victim_groups[]">
					<div class="input-group-prepend">
						<span class="input-group-text" style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
					</div>
					<input type="text" class="form-control" placeholder="" id="victim_individuals" name="victim_individuals[]">
				</div>
			</td>
		</tr>`;
		$("#VictimTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveVictim", function() {
		$(this).closest("tr").remove();
	});

	//<!------------------ ទីតាំងវាយប្រហារ ------------------>
	$("#btnAddMoreAttackLocation").click(function() {
		var newRow = `
			<tr>
				<td>
					<div class="input-group">
						<button type="button" class="btn btn-danger btn-xs"
							id="btnRemoveAttackLocation">
							<i class="fas fa-minus" aria-hidden="true"></i>
						</button>
						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">ប្រទេស</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="attacked_countries"
							name="attacked_countries[]">
						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">ខេត្ត/ក្រុង</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="attacked_provinces"
							name="attacked_provinces[]">

						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">តំបន់</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="attacked_areas"
							name="attacked_areas[]">
					</div>
				</td>
			</tr>`;
		$("#AttackLocationTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveAttackLocation", function() {
		$(this).closest("tr").remove();
	});
	//<!----------------អ្នកបង្រ្កាប-------------->
	$("#btnAddMoreProvocative").click(function() {
		var newRow = `
			<tr>
				<td>
					<div class="input-group">
						<button type="button" class="btn btn-danger btn-xs"
							id="btnRemoveProvocative">
							<i class="fas fa-minus" aria-hidden="true"></i>
						</button>
						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="suppressors_orgs"
							name="suppressors_orgs[]">

						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">ក្រុម</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="suppressor_groups"
							name="suppressor_groups[]">

						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="suppressor_individuals"
							name="suppressor_individuals[]">
					</div>
				</td>
			</tr>
		`;
		$("#suppressorsTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveProvocative", function() {
		$(this).closest("tr").remove();
	});


	//<!------------------ ទីតាំងបង្ក្រាប ------------------>
	$("#btnAddMoreCrackdownLocation").click(function() {
		var newRow = `
			<tr>
				<td>
					<div class="input-group">
						<button type="button" class="btn btn-danger btn-xs"
							id="btnRemoveCrackdownLocation">
							<i class="fas fa-minus" aria-hidden="true"></i>
						</button>
						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">ប្រទេស</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="crackdown_countries"
							name="crackdown_countries[]">

						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">ខេត្ត/ក្រុង</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="crackdown_provinces"
							name="crackdown_provinces[]">

						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">តំបន់</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="crackdown_areas"
							name="crackdown_areas[]">
					</div>
				</td>
			</tr>
		`;
		$("#CrackdownLocationTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveCrackdownLocation", function() {
		$(this).closest("tr").remove();
	});
	//<!------------------ អ្នកដែលត្រូវបានបង្ក្រាប ------------------>
	$("#btnAddMoreSuppressed").click(function() {
		var newRow = `
			<tr>
				<td>
					<div class="input-group">
						<button type="button" class="btn btn-danger btn-xs"
							id="btnRemoveSuppressed">
							<i class="fas fa-minus" aria-hidden="true"></i>
						</button>
						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">អង្គភាព</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="suppressed_orgs"
							name="suppressed_orgs[]">

						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">ក្រុម</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="suppressed_groups"
							name="suppressed_groups[]">

						<div class="input-group-prepend">
							<span class="input-group-text"
								style="font-weight: 200; font-size: 15px;">បុគ្គល</span>
						</div>
						<input type="text" class="form-control"
							placeholder="" id="suppressed_individuals"
							name="suppressed_individuals[]">

					</div>
				</td>
			</tr>
		`;
		$("#SuppressedTable tbody").append(newRow);
	});
	// Remove row button click event
	$(document).on("click", "#btnRemoveSuppressed", function() {
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
	////Datemask2 mm/dd/yyyy
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
	////Date range picker with time picker
	$('#reservationtime').daterangepicker({
		timePicker: true,
		timePickerIncrement: 30,
		locale: {
			format: 'MM/DD/YYYY hh:mm A'
		}
	})
	//Date range as a button
	$('#daterange-btn').daterangepicker({
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
					.endOf('month')
				]
			},
			startDate: moment().subtract(29, 'days'),
			endDate: moment()
		},
		function(start, end) {
			$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
		}
	)

	//Timepicker
	$('#timepicker').datetimepicker({
		format: 'LT'
	})



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