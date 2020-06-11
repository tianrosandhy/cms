@extends ('core::layouts.master')
@section ('content')

<h2>Media Manager Test</h2>

<div class="card card-body">
	<form action="" method="post">
		{!! Media::multiple('image[]', null) !!}

		<button type="submit" class="btn btn-primary">Test Submit</button>
	</form>
</div>
@stop

@push ('script')
{!! Media::assets() !!}
@endpush