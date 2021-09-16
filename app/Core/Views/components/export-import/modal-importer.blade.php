<div class="modal fade modal-importer" id="importBox-{{ $structure->name() }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h6>Import from Excel</h6>
				<button data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body">
                @if(method_exists($structure, 'exportRoute'))
                <p>You can import data to this module by upload the excel with the example format below : </p>
                <a href="{{ $structure->exportRoute() }}?dummy=true" class="btn btn-sm btn-primary mb-3">
                    <span class="iconify" data-icon="bi:cloud-download-fill"></span> Download Excel File Example
                </a>
                @endif

                <p>Please upload the right format data below : </p>
                <form method="post" enctype="multiple/form-data" action="{{ $structure->importRoute() }}" class="import-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="pre_import_id" value="{{ date('YmdHis') }}">
                    {!! Input::file('import', [
                        'attr' => [
                            'accept' => '.xlsx, .xls, .csv'
                        ]
                    ]) !!}
                </form>

            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    $(document).on('submit', ".import-form", function(){
        showLoading();
    });

    $(document).on('change', '.import-form .listen_uploaded_file', function(e){
        $(".import-form").submit();
    });
});
</script>