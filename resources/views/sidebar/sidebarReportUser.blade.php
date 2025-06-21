<li class="nav-item">
	<a href="{{ route('dashboard') }}" class="nav-link ">
		<i class="fa fa-university nav-icon"></i>
		<p>
			ទំព័រដើម
		</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{ route('search-case-information') }}" class="nav-link Battambang  ">
		<i class="fa fa-university nav-icon"></i>
		<p>ស្វែងរកព្រឹត្តិការណ៍</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{ route('CaseList') }}" class="nav-link Battambang">
		<i class="nav-icon fas fa-th"></i>
		<p>បញ្ជីព្រឹត្តិការណ៍</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{ route('case-information-create') }}" class="nav-link Battambang">
		<i class="nav-icon fas fa-plus"></i>
		<p>
			បង្កើតព្រឹត្តិការណ៍
		</p>
	</a>
</li>

@if(Auth::user()->role == 'ADMIN')

<li class="nav-item Battambang">
	<a href="#" class="nav-link">
		<i class="fa fa-university nav-icon"></i>
		<p>
			គ្រប់គ្រងប្រព័ន្ធ
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="{{ route('user-list') }}" class="nav-link">
				<i class="far fa-minus-square nav-icon"></i>
				<p>បញ្ជីបុគ្គលិក</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('user-create') }}" class="nav-link">
				<i class="far fa-minus-square nav-icon"></i>
				<p>ចុះឈ្មោះ</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('country-list') }}" class="nav-link">
				<i class="far fa-minus-square nav-icon"></i>
				<p>បញ្ជីប្រទេស</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('action-list') }}" class="nav-link">
				<i class="far fa-minus-square nav-icon"></i>
				<p>បញ្ជីសកម្មភាព</p>
			</a>
		</li>
	</ul>
</li>
<li class="nav-item Battambang">
	<a href="#" class="nav-link active">
		<i class="fa fa-university nav-icon"></i>
		<p>
			របាយការណ៍
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item ">
			<a href="{{ route('report-user-query') }}" class="nav-link active">
				<i class="far fa-minus-square nav-icon"></i>
				<p>របាយការណ៍ អ្នក​ប្រើប្រាស់</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('report-summary-case-query') }}" class="nav-link ">
				<i class="far fa-minus-square nav-icon"></i>
				<p>របាយការណ៍ បូកសរុបករណី</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('report-summary-case-by-country-query') }}" class="nav-link ">
				<i class="far fa-minus-square nav-icon"></i>
				<p>របាយការណ៍ បូកសរុបករណីតាមប្រទេស</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('report-case-query') }}" class="nav-link">
				<i class="far fa-minus-square nav-icon"></i>
				<p>របាយការណ៍ ករណី</p>
			</a>
		</li>

	</ul>
</li>
@endif