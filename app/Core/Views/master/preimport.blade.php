@extends ('core::layouts.master')

@section ('content')

    @include ('core::components.export-import.importer-show-errors', ['printLimit' => 5])

    <?php
    $maxShown = $maxShown ?? 20;
    ?>
    <div class="alert alert-info">
        <p class="my-0">Below are {{ count($data['rawData']) }} {!! count($data['rawData']) > $maxShown ? '('.$maxShown.' shown)' : '' !!} data that will be imported. Please make sure everything is okay before start the import by clicking the button below</p>

        <form action="" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="import_id" value="{{ encrypt($data['tempPath']) }}">
            <button class="btn btn-rounded btn-primary btn-lg"><span class="iconify" data-icon="carbon:document-import"></span> Start Import</button>
            @if(isset($back_url))
                <a href="{{ $back_url }}" class="btn btn-rounded btn-danger">Cancel Import</a>
            @endif
        </form>
    </div>

    <div class="card p-3">
        <table class="table bg-white table-hover table-sm p-3">
            <thead>
                <tr>
                    @foreach($data['headerMap'] as $headerLabel => $headerName)
                    <th>{{ ucwords($headerLabel) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data['rawData'] as $row)
                    <tr>
                        @foreach($data['headerMap'] as $headerLabel => $headerName)
                            <?php
                            $index = $data['rawHeaderFlipped'][$headerLabel] ?? -1;
                            ?>
                            @if($index > -1)
                            <td>{{ $row[$index] }}</td>
                            @else
                            <td>-</td>
                            @endif
                        @endforeach
                    </tr>
                    @if($loop->iteration >= $maxShown)
                        <tr>
                            <td colspan="{{ count($row) }}">...</td>
                        </tr>
                        @break
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@stop