<?php
$printLimit = $printLimit ?? 5;
?>
@if(isset($data['rowValidator']['errors']))
    @if(count($data['rowValidator']['errors']) > 0)
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h6 class="text-white mb-0">Fatal Error</h6>
        </div>
        <div class="card-body">
            <ul class="mb-0">
            @foreach($data['rowValidator']['errors'] as $err)
                <li>{{ $err }}</li>
                @if($loop->iteration >= $printLimit)
                    <li>...</li>
                    @break
                @endif
            @endforeach
            </ul>
        </div>
    </div>
    @endif
@endif
@if(isset($data['rowValidator']['warnings']))
    @if(count($data['rowValidator']['warnings']) > 0)
    <div class="card">
        <div class="card-header bg-warning">
            <h6 class="mb-0">Warnings</h6>
        </div>
        <div class="card-body">
            <ul class="mb-0">
            @foreach($data['rowValidator']['warnings'] as $warn)
                <li>{{ $warn }}</li>
                @if($loop->iteration >= $printLimit)
                    <li>...</li>
                    @break
                @endif
            @endforeach
            </ul>
        </div>
    </div>
    @endif
@endif
