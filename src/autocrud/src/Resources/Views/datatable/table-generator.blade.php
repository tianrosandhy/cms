<div class="card card-body">
    @include ('autocrud::datatable.table-control-button')
    @include ('autocrud::datatable.table-filter-modal')

    <table class="table datatable" id="autocrud-table-{{ $hash }}">
        <thead>
            <tr>
                @foreach($structure as $struct)
                <th data-field="{{ $struct->getField() }}" data-orderable="{{ $struct->getOrderable() }}" data-searchable="{{ $struct->getSearchable() }}" data-inputtype="{{ $struct->getInputType() }}">{{ $struct->getName() }}</th>
                @endforeach
                <th data-field="action"></th>
            </tr>
        </thead>
        <tbody></tbody>    
    </table>

</div>
