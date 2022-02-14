@extends ($base_layout ?? 'core::layouts.master')
@section ('content')
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