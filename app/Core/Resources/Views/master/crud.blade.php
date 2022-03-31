@extends ($base_layout ?? 'core::layouts.master')
@section ('content')
    @if (isset($structure))
        <div class="card card-body">
        {!! $structure->render() !!}
        </div>
    @endif
@stop
