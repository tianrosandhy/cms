@extends ($base_layout ?? 'themes::master')
@section ('content')
    @if (isset($structure))
        <div class="card card-body">
        {!! $structure->render() !!}
        </div>
    @endif
@stop
