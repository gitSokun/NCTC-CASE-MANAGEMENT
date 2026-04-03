@extends('layouts.master')

@section('title_page')
ផ្ទាំងគ្រប់គ្រង ព្រឹត្តិការណ៍ (NCTC - {{ date('Y') }})
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ទំព័រដើម</a></li>
@endsection

@section('sidebar')
@include('sidebar.dashboard-side')
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<!-- ./col -->
		
		<!-- /.col (LEFT) -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box">
				<div class="inner" style="background-color: #6610f2d1; color: white;">
					<p>សរុប ការវាយប្រហារ: {{$totalCausingCase}}</p>
					<p>សរុប ការបង្ក្រាប: {{$totalCrackdownCase}}</p>
					<p>សរុប ផ្សេងៗ: {{$totalOtherCase}}</p>
				</div>
				
			</div>
		</div>
		<!-- ./col -->
		<!-- /.col (LEFT) -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-info">
				<div class="inner">
					<h3>{{$totalCases}}</h3>

					<p>ចំនួនព្រឹត្តិការណ៍ សរុប</p>
				</div>
				<div class="icon">
					<!--<i class="ion ion-bag"></i>-->
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="{{ route('CaseList') }}" class="small-box-footer">ព័ត៌មាន​បន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-warning ">
				<div class="inner">
					<h3>{{$totalOriginalCase}}<sup style="font-size: 20px"></sup></h3>

					<p>ចំនួនព្រឹត្តិការណ៍មិនទាន់បកប្រែ</p>
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="{{ route('CaseList') }}" class="small-box-footer">ព័ត៌មាន​បន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->
		<div class="col-lg-3 col-6">
			<!-- small box -->
			<div class="small-box bg-success">
				<div class="inner">
					<h3>{{$totalCaseTranslated}}</h3>

					<p>ចំនួនព្រឹត្តិការណ៍បកប្រែរួចរាល់</p>
				</div>
				<div class="icon">
					<!--<i class="ion ion-stats-bars"></i>-->
					<!--<i class="ion ion-person-add"></i>-->
				</div>
				<a href="{{ route('CaseList') }}" class="small-box-footer">ព័ត៌មាន​បន្ថែម <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-md-12">
			<!-- LINE CHART -->

			<!-- /.card -->

			<!-- BAR CHART -->
			<div class="card card-success">
				<div class="card-header">
					<h3 class="card-title">ចំនួនព្រឹត្តិការណ៍ និង អ្នកប្រើប្រាស់ ប្រចាំ​ឆ្នាំ {{ date('Y') }}</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="chart">
						<canvas id="barChart"
							style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->

			

		</div>
		
		<!-- /.col (RIGHT) -->
	</div>
	<!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('script')
<script>
 var monthlyTotals = @json($monthlyCases);
 var monthlyOtherCases = @json($monthlyOtherCases);
 var monthlyCausingCases = @json($monthlyCausingCases);
 var monthlyCrackdownCase = @json($monthlyCrackdownCase);
$(function() {
	/* ChartJS
	 * -------
	 * Here we will create a few charts using ChartJS
	 */

	//--------------
	//- AREA CHART -
	//--------------

	// Get context with jQuery - using jQuery's .get() method.
	//var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

	var areaChartData = {
		labels: ['មករា', 'កុម្ភៈ', 'មិនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា',
			'វិច្ឆិកា', 'ធ្នូ'
		],
		datasets: [{
				label: 'ចំនួនព្រឹត្តិការណ៍',
				backgroundColor: 'rgba(60,141,188,0.9)',
				borderColor: 'rgba(60,141,188,0.8)',
				pointRadius: false,
				pointColor: '#3b8bba',
				pointStrokeColor: 'rgba(60,141,188,1)',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(60,141,188,1)',
				data: monthlyTotals //[28, 48, 40, 19, 86, 27, 90, 100]
			},
			{
				label: 'ចំនួនការវាយប្រហារ',
				backgroundColor: 'rgba(260, 198, 211, 1)',
				borderColor: 'rgba(260, 198, 211, 1)',
				pointRadius: false,
				pointColor: 'rgba(260, 198, 211, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: monthlyOtherCases //[65, 59, 80, 81, 56, 55, 40, 20]
			},
			{
				label: 'ចំនួនការបង្ក្រាប',
				backgroundColor: 'rgba(255, 99, 132, 1)',
				borderColor: 'rgba(255, 99, 132, 1)',
				pointRadius: false,
				pointColor: 'rgba(255, 99, 132, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: monthlyCausingCases //[65, 59, 80, 81, 56, 55, 40, 20]
			},
			{
				label: 'ចំនួនផ្សេងៗ',
				backgroundColor: 'rgba(255, 193, 7, 1)',
				borderColor: 'rgba(255, 193, 7, 1)',
				pointRadius: false,
				pointColor: 'rgba(255, 193, 7, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: monthlyCrackdownCase //[65, 59, 80, 81, 56, 55, 40, 20]
			},
		]
	}

	var areaChartOptions = {
		maintainAspectRatio: false,
		responsive: true,
		legend: {
			display: false
		},
		scales: {
			xAxes: [{
				gridLines: {
					display: false,
				}
			}],
			yAxes: [{
				gridLines: {
					display: false,
				}
			}]
		}
	}



	//-------------
	//- BAR CHART -
	//-------------
	var barChartCanvas = $('#barChart').get(0).getContext('2d')
	var barChartData = $.extend(true, {}, areaChartData)
	var temp0 = areaChartData.datasets[0]
	var temp1 = areaChartData.datasets[1]
	var temp2 = areaChartData.datasets[2]
	var temp3 = areaChartData.datasets[3]
	barChartData.datasets[0] = temp0
	barChartData.datasets[1] = temp1
	barChartData.datasets[2] = temp2
	barChartData.datasets[3] = temp3

	var barChartOptions = {
		responsive: true,
		maintainAspectRatio: false,
		datasetFill: false
	}

	new Chart(barChartCanvas, {
		type: 'bar',
		data: barChartData,
		options: barChartOptions
	})


})
</script>
@endsection