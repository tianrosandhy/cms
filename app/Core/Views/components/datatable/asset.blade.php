<link rel="stylesheet" href="{{ admin_asset('libs/datatable/datatables.min.css') }}">
<script type="text/javascript" src="{!! admin_asset('libs/datatable/DataTables/js/jquery.dataTables.min.js') !!}"></script>
<script type="text/javascript" src="{!! admin_asset('libs/datatable/Responsive/js/dataTables.responsive.min.js') !!}"></script>
<script type="text/javascript" src="{!! admin_asset('libs/datatable/FixedHeader/js/dataTables.fixedHeader.min.js') !!}"></script>
<script type="text/javascript" src="{!! admin_asset('libs/datatable/FixedColumns/js/dataTables.fixedColumns.min.js') !!}"></script>
<script type="text/javascript" src="{!! admin_asset('libs/datatable/ColReorder/js/dataTables.colReorder.min.js') !!}"></script>
<script>
var tb_data;
$(function(){
	tb_data = $("table.datatable").DataTable({
		'processing': true,
		'serverSide': true,
		'autoWidth' : false,
		'searching'	: false,
		'filter'	: false,
		'stateSave'	: true,
		'scrollY' : '500px',
		'scrollX' : true,
		'scrollCollapse' : true,
		'colReorder' : true,
		'ajax'		: {
			type : 'POST',
			url	: '{{ $structure->route() }}',
			dataType : 'json',
			data : function(data){
				{!! $structure->generateSearchQuery() !!}
				data._token = window.CSRF_TOKEN
			},
		},
		createdRow: function( row, data, dataIndex ) {
			// Set the data-status attribute, and add a class
			$( row ).addClass('close-target');
		},

		"drawCallback": function(settings) {
			initPlugins();
			setTimeout(function(){
				$("table.datatable").resize();
			}, 250);
		},
		'columns' : [
			{!! $structure->datatableColumns() !!}
		],
		'columnDefs' : [
			{!! $structure->datatableOrderable() !!}
		],
		"aaSorting": [{!! $structure->datatableDefaultOrder() !!}],
	});

	$(".search-box input, .search-box select").on('keyup', function(e){
		if(e.which == 13){
			refreshDataTable();
			$(".modal-searchbox").closest('.modal.show').modal('hide');
		}
	});

	$(".modal-searchbox .btn-apply-filter").on('click', function(e){
		e.preventDefault();
		refreshDataTable();
		$(".modal-searchbox").closest('.modal.show').modal('hide');
	});

	$(".reset-filter").on('click', function(e){
		e.preventDefault();
		$(this).closest('.modal-searchbox').find('input, select').val('').trigger('change');
		$(".modal-searchbox").closest('.modal.show').modal('hide');
		refreshDataTable();
	});

	$(".modal-pagefilter").on('shown.bs.modal', function(){
		refreshPlugins();
	});


	$(document).on('change', '#checker_all_datatable', function(){
		cond = $(this).is(':checked');
		$(".multichecker_datatable").each(function(){
			$(this).prop('checked', cond);
		});
		toggleBatchMode();
	});

	$(document).on('change', '.multichecker_datatable', function(){
		toggleBatchMode();
	});

	$(".multi-delete").on('click', function(e){
		e.preventDefault();
		output = '<p>Are you sure? Once deleted, you will not be able to recover the data</p><button class="btn btn-primary" data-dismiss="modal">Cancel</button> <button class="btn btn-danger" onclick="runRemoveBatch()">Yes, Delete</button>';
		toastr.info(output);
	});

});

function refreshDataTable(){
	tb_data.ajax.reload();
}

function toggleBatchMode(){
	cond = false;
	$(".multichecker_datatable").each(function(){
		if($(this).is(':checked')){
			cond = true;
		}
	});

	if(cond){
		//toggle down
		$(".batchbox").slideDown();
	}
	else{
		//toggle up
		$(".batchbox").slideUp();
		$("#checker_all_datatable").prop('checked', false);
	}
}

function runRemoveBatch(){
	//prepare selected ids
	ids = [];
	$(".multichecker_datatable").each(function(){
		if($(this).is(':checked')){
			ids.push($(this).attr('data-id'));
		}
	});

	if(ids.length > 0){
		$.ajax({
			url : $(".multi-delete").attr('href'),
			type : 'POST',
			dataType : 'json',
			data : {
				_token : window.CSRF_TOKEN,
				list_id : ids
			},
			success : function(resp){
				if(resp.type == 'success'){
					toastr.success(resp.message);
					//refresh datatable
					refreshDataTable();
					$("#checker_all_datatable").prop('checked', false);
					$(".batchbox").slideUp();
				}
				else{
					toastr.error(resp.message);
				}
			},
			error : function(resp){
				toastr.error('Sorry, we cannot process your request now.');
			}
		});			
	}
	else{
		toastr.error('No data selected');
	}


}
</script>