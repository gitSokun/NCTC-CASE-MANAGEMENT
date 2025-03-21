@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="dashboard.html">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">បញ្ជីប្រទេស</li>
@endsection

@section('sidebar')
@include('sidebar.sidebarCountryCreate')
@endsection

@section('content')
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-2">
								<button type="button" class="btn btn-primary Battambang" data-toggle="modal"
									data-target="#modal-new-country">
									បង្កើតប្រទេស </button>
							</div>
							<div class="col-10">
								<form method="POST" action="{{ route('search-country-index') }}">
									{{ csrf_field() }}
									<div class="input-group input-group-lg">
										<input type="search" name="search" id="search" value="{{$search}}"
											class="form-control form-control-lg" placeholder="ស្វែងរកប្រទេស" value="">
										<div class="input-group-append">
											<button type="submit" class="btn btn-lg btn-default">
												<i class="fa fa-search"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="modal fade" id="modal-new-country">
						<div class="modal-dialog">
							<form class="form-horizontal" enctype="multipart/form-data" id="newCountry" method="POST"
								action="{{ route('store-country') }}">
								{{ csrf_field() }}
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">បង្កើតប្រទេស</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">

										<div class="row">
											<div class="col-sm-12">
												<label class='label1' style="font-weight: 200;">លេខកូដ</label>
												<input type="text" class="form-control " id="country_code"
													name="country_code" placeholder="">
											</div>
											<div class="col-sm-12">
												<label class='label1'
													style="font-weight: 200;">ឈ្មោះជាភាសាអង់គ្លេស</label>
												<input type="text" class="form-control " id="country_eng"
													name="country_eng" placeholder="">
											</div>
											<div class="col-sm-12">
												<label class='label1' style="font-weight: 200;">ឈ្មោះជាភាសាខ្មែរ</label>
												<input type="text" class="form-control " id="country_kh"
													name="country_kh" placeholder="">
											</div>
										</div>


									</div>
									<div class="modal-footer justify-content-between">
										<button type="button" class="btn btn-default" data-dismiss="modal"><i
												class="fas fa-arrow-close" aria-hidden="true"></i> បិទ</button>
										<button type="submit" class="btn btn-primary"><i class="fas fa-save"
												aria-hidden="true"></i> រក្សាទុក</button>
									</div>
								</div>

							</form>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>

					<!-- /.card-header -->
					<div class="card-body">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr class="Battambang">
									<th style="width: 15%;">#</th>
									<th>លេខកូដ</th>
									<th>ឈ្មោះជាភាសាអង់គ្លេស</th>
									<th>ឈ្មោះជាភាសាខ្មែរ</th>
									<th style="width: 40%;">សកម្មភាព</th>
								</tr>
							</thead>
							<tbody>
								@foreach($countries as $country)

								<tr class="Battambang">
									<td>
										<p style="font-weight: 100;">{{$country->id}}{{$country->code}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$country->code}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$country->name_eng}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$country->name_kh}}</p>
									</td>

									<td>
										<div class="btn-group" style="float: right;">
											<button type="submit" class="btn btn-success" data-toggle="modal"
												data-target="#modal-view-country">
												<i class="fas fa-eye" aria-hidden="true"></i> មើល
											</button>
											<button type="submit" class="btn btn-warning" style="width: 135px;"
												data-toggle="modal" data-target="#modal-edit-country">
												<i class="fas fa-edit" aria-hidden="true"></i> កែសម្រួល
											</button>
											<!--<button type="submit" class="btn btn-danger"
												onclick="location.href='{{ url('/case-information-delete/' . Crypt::encrypt($country->id)) }}'">
												<i class="fas fa-trash" aria-hidden="true"></i> លុប
											</button>-->

											<div class="modal fade" id="modal-view-country">
												<div class="modal-dialog">

													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title">ប្រទេស</h4>
															<button type="button" class="close" data-dismiss="modal"
																aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">

															<div class="row">
																<div class="col-sm-12">
																	<label class='label1'
																		style="font-weight: 200;">លេខកូដ</label>
																	<input type="text" class="form-control "
																		id="country_code" name="country_code"
																		placeholder="" value="{{$country->code}}"
																		disabled>
																</div>
																<div class="col-sm-12">
																	<label class='label1'
																		style="font-weight: 200;">ឈ្មោះជាភាសាអង់គ្លេស</label>
																	<input type="text" class="form-control "
																		id="country_eng" name="country_eng"
																		placeholder="" value="{{$country->name_eng}}"
																		disabled>
																</div>
																<div class="col-sm-12">
																	<label class='label1'
																		style="font-weight: 200;">ឈ្មោះជាភាសាខ្មែរ</label>
																	<input type="text" class="form-control "
																		id="country_kh" name="country_kh" placeholder=""
																		value="{{$country->name_kh}}" disabled>
																</div>
															</div>


														</div>
														<div class="modal-footer justify-content-between">
															<button type="button" class="btn btn-default"
																data-dismiss="modal"><i class="fas fa-arrow-close"
																	aria-hidden="true"></i> បិទ</button>
														</div>
													</div>

													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>

											<div class="modal fade" id="modal-edit-country">
												<div class="modal-dialog">
													<form class="form-horizontal" enctype="multipart/form-data"
														id="newCountry" method="POST"
														action="{{ route('update-country') }}">
														{{ csrf_field() }}
														<input class="form-control " id="id" name="id"
															value="{{$country->id}}" placeholder="" hidden>

														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">កែប្រែប្រទេស</h4>
																<button type="button" class="close" data-dismiss="modal"
																	aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">

																<div class="row">
																	<div class="col-sm-12">
																		<label class='label1'
																			style="font-weight: 200;">លេខកូដ</label>
																		<input type="text" class="form-control "
																			id="country_code" name="country_code"
																			placeholder="" value="{{$country->code}}">
																	</div>
																	<div class="col-sm-12">
																		<label class='label1'
																			style="font-weight: 200;">ឈ្មោះជាភាសាអង់គ្លេស</label>
																		<input type="text" class="form-control "
																			id="country_eng" name="country_eng"
																			placeholder=""
																			value="{{$country->name_eng}}">
																	</div>
																	<div class="col-sm-12">
																		<label class='label1'
																			style="font-weight: 200;">ឈ្មោះជាភាសាខ្មែរ</label>
																		<input type="text" class="form-control "
																			id="country_kh" name="country_kh"
																			placeholder=""
																			value="{{$country->name_kh}}">
																	</div>
																</div>


															</div>
															<div class="modal-footer justify-content-between">
																<button type="button" class="btn btn-default"
																	data-dismiss="modal"><i class="fas fa-arrow-close"
																		aria-hidden="true"></i> បិទ</button>
																<button type="submit" class="btn btn-primary"><i
																		class="fas fa-save" aria-hidden="true"></i>
																	រក្សាទុក</button>
															</div>
														</div>

													</form>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>

										</div>

									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{{ $countries->links() }}
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection