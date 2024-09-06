@extends('layouts.master')

@section('title_page')
ផ្ទាំងគ្រប់គ្រង ព្រឹត្តិការណ៍ (NCTC - 2024)
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
		
		
	</div>
	<!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('script')
<script>
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
				data: [28, 48, 40, 19, 86, 27, 90, 100]
			},
			{
				label: 'ចំនួនអ្នកចូលមើលព្រឹត្តិការណ៍',
				backgroundColor: 'rgba(210, 214, 222, 1)',
				borderColor: 'rgba(210, 214, 222, 1)',
				pointRadius: false,
				pointColor: 'rgba(210, 214, 222, 1)',
				pointStrokeColor: '#c1c7d1',
				pointHighlightFill: '#fff',
				pointHighlightStroke: 'rgba(220,220,220,1)',
				data: [65, 59, 80, 81, 56, 55, 40, 20]
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
	barChartData.datasets[0] = temp1
	barChartData.datasets[1] = temp0

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