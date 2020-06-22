@extends ('core::layouts.master')
@section ('content')
	@include ('core::components.header-box')

	<form action="" method="post">
		{{ csrf_field() }}
		@if(isset($datatable))
			{!! $datatable->tableView() !!}
		@endif
	</form>
@stop

@section ('datatable_script')
	@if(isset($datatable))
		{!! $datatable->assets() !!}
	@endif
@stop