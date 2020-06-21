@extends ('core::layouts.master')
@section ('content')
	@include ('core::components.header-box', [
		'control_buttons' => [
			[
				'url' => admin_url('/'),
				'label' => 'Back to Homepage',
				'icon' => 'home'
			],
			[
				'url' => route('admin.page.create'),
				'label' => 'Add Data',
				'type' => 'success',
				'icon' => 'plus'
			],
			[
				'label' => 'Filter',
				'icon' => 'filter',
				'type' => 'primary',
				'attr' => [
					'data-toggle' => 'collapse',
					'data-target' => '#searchBox-' . $skeleton->name()
				]
			]
		]
	])

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