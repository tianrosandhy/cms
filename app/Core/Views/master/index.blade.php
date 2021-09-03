@extends ('core::layouts.master')
@section ('content')
	@include ('core::components.header-box')

	<div class="page-content-wrapper">
		<div class="container-fluid">
			<div class="card">
				<div class="card-body">
				@if(isset($datatable))
					@if($datatable->mode  <> 'datatable')
						{!! $datatable->customTableView() !!}
					@else
						{!! $datatable->tableView() !!}
					@endif
				@endif
				</div>
			</div>
		</div>
	</div>

@stop

@section ('datatable_script')
	@if(isset($datatable))
		@if($datatable->mode <> 'datatable')
			{!! $datatable->customAssets() !!}
		@else
			{!! $datatable->assets() !!}
		@endif
	@endif
@stop