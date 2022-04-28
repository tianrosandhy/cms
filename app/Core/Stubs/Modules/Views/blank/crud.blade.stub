@extends (request()->ajax() ? 'themes::master-ajax' : 'themes::master')
@section ('content')
    @if (isset($structure))
        <div class="card card-body">
        {!! $structure->render() !!}
        </div>
    @endif
@stop
