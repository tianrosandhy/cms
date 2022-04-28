@extends ($base_layout ?? 'themes::master')
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