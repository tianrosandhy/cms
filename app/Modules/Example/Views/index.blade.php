@extends ($base_layout ?? 'core::layouts.master')

@section ('control_buttons')
    <a href="{{ route('admin.example.create') }}" class="btn btn-rounded btn-success page-navigate" data-popup-lg="1">
        <span>Tambah Data</span>
    </a>
@stop

@section ('content')
    @if (isset($structure))
	<div class="card">
		<div class="card-body">
        {!! $structure->render() !!}
		</div>
	</div>
    @endif
@stop
 
@push ('script')
	@if(isset($structure))
        {!! $structure->renderAsset() !!}
	@endif
@endpush