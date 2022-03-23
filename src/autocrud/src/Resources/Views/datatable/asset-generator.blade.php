<script type="text/javascript">
var tb_data_{{ $hash }};
$(function(){

    tb_data = $("table.datatable#autocrud-table-{{ $hash }}").DataTable({
        'processing': true,
        'serverSide': true,
        'searching': false,
        'filter': false,
        'stateSave': true,
        'scrollY': '500px',
        'scrollX': true,
        'ajax': {
            type : 'POST',
            url	: '{{ $context->datatableRoute() }}',
            dataType : 'json',
            data : function(data){
                {!! $context->generateSearchQuery() !!}
                data._token = '{{ csrf_token() }}'
            },
        },
        'createdRow': function( row, data, dataIndex ) {
            // Set the data-status attribute, and add a class
            $( row ).addClass('close-target');
        },

        'drawCallback': function(settings) {
            if (typeof afterDatatableLoad == 'function') {
                afterDatatableLoad();
            }
        },
		'columns' : [
			{!! $context->datatableColumns() !!}
		],
		'columnDefs' : [
			{!! $context->datatableOrderable() !!}
		],
		"aaSorting": [{!! $context->datatableDefaultOrder() !!}],
    });

    $("#searchBox-{{ $hash }} input, #searchBox-{{ $hash }} select").on('keyup', function(e){
        if(e.which == 13){
            refreshDataTable{{ $hash }}();
            $("#searchBox-{{ $hash }}").modal('hide');
        }
    });

    $("#searchBox-{{ $hash }} .btn-apply-filter").on('click', function(e){
        e.preventDefault();
        refreshDataTable{{ $hash }}();
        $("#searchBox-{{ $hash }}").modal('hide');
    });

    $(".reset-filter").on('click', function(e){
        e.preventDefault();
        $(this).closest('#searchBox-{{ $hash }}').find('input, select').val('').trigger('change');
        $("#searchBox-{{ $hash }}").modal('hide');
        refreshDataTable{{ $hash }}();
    });

    $(".modal-pagefilter").on('shown.bs.modal', function(){
        if (typeof afterDatatableFilterLoad == 'function') {
            afterDatatableFilterLoad();
        }
    });

});

function refreshDataTable{{ $hash }}(){
	tb_data.ajax.reload();
}
</script>