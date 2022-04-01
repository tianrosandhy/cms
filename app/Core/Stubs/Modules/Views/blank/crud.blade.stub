@extends (request()->ajax() ? 'core::layouts.master-ajax' : 'core::layouts.master')
@section ('content')
    @if (isset($structure))
        <div class="card card-body">
        {!! $structure->render() !!}
        </div>
    @endif
@stop
