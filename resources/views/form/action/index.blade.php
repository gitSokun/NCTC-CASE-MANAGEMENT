@extends('layouts.master')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="dashboard.html">ទំព័រដើម</a></li>
<li class="breadcrumb-item active">បញ្ជីសកម្មភាព</li>
@endsection
@section('sidebar')
@include('sidebar.dashboard-side')
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
									data-target="#modal-new-action">
									បង្កើតសកម្មភាព </button>
							</div>
						</div>
					</div>

					<div class="modal fade" id="modal-new-action">
						<div class="modal-dialog">
							<form class="form-horizontal" enctype="multipart/form-data" id="newAction" method="POST"
								action="{{ route('store-action') }}">
								{{ csrf_field() }}
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">បង្កើតសកម្មភាព</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">

										<div class="row">
											<div class="col-sm-12">
												<label class='label1' style="font-weight: 200;">សកម្មភាព</label>
												<input type="text" class="form-control " id="action_name"
													name="action_name" placeholder="">
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
									<th>សកម្មភាព</th>
									<th style="width: 40%;">-----</th>
								</tr>
							</thead>
							<tbody>
								@foreach($actions as $action)

								<tr class="Battambang">
									<td>
										<p style="font-weight: 100;">{{$action->id}}</p>
									</td>
									<td>
										<p style="font-weight: 100;">{{$action->name}}</p>
									</td>

									<td>
										<div class="btn-group" style="float: right;">
											<button type="submit" class="btn btn-success" data-toggle="modal"
												data-target="#modal-view-action">
												<i class="fas fa-eye" aria-hidden="true"></i> មើល
											</button>
											<button type="submit" class="btn btn-warning" style="width: 135px;"
												data-toggle="modal" data-target="#modal-edit-action">
												<i class="fas fa-edit" aria-hidden="true"></i> កែសម្រួល
											</button>

											<div class="modal fade" id="modal-view-action">
												<div class="modal-dialog">

													<div class="modal-content">
														<div class="modal-header">
															<h4 class="modal-title">សកម្មភាព</h4>
															<button type="button" class="close" data-dismiss="modal"
																aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">

															<div class="row">
																<div class="col-sm-12">
																	<label class='label1'
																		style="font-weight: 200;">សកម្មភាព</label>
																	<input type="text" class="form-control "
																		id="action_name" name="action_name"
																		placeholder="" value="{{$action->name}}"
																		disabled>
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

											<div class="modal fade" id="modal-edit-action">
												<div class="modal-dialog">
													<form class="form-horizontal" enctype="multipart/form-data"
														id="newCountry" method="POST"
														action="{{ route('update-action') }}">
														{{ csrf_field() }}
														<input class="form-control " id="id" name="id"
															value="{{$action->id}}" placeholder="" hidden>

														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">កែប្រែសកម្មភាព</h4>
																<button type="button" class="close" data-dismiss="modal"
																	aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">

																<div class="row">
																	<div class="col-sm-12">
																		<label class='label1'
																			style="font-weight: 200;">សកម្មភាព</label>
																		<input type="text" class="form-control "
																			id="action_name" name="action_name"
																			placeholder="" value="{{$action->name}}">
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
						{{ $actions->links() }}
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