<div id="modal-change-confirmation" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmation
                <button class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="back-confirmation">
                    <p class="lead">Your data <strong>will not be saved</strong> if you go back now. Do you still want to go back?</p>
                    <div>
                        <a href="#" class="btn btn-danger btn-real-back">Back, and Remove All Changes</a>
                        <a href="#" class="btn btn-white" data-dismiss="modal" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </div>
                <div class="save-confirmation">
                    <p class="lead">Please make sure that all the data is correctly filled. Click button below to continue save your data</p>
                    <div>
                        <a href="#" class="btn btn-success btn-trigger-resend">Continue, and Save Data</a>
                        <a href="#" class="btn btn-white" data-dismiss="modal" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var HAS_CHANGE = false;
var FORM_INIT_DATA = null;
$(function(){
	window.FORM_INIT_DATA = $(".content form").serialize();
	//update HAS_CHANGE value berdasarkan event change di all input
	$(document).on("change", ".content form input, .content form textarea, .content form select", function(){
        detectFormChange();
	});

    @if(config('cms.admin.crud_confirmation_on_back'))
	$(document).on('click', "[data-back-button], .page-navigate", function(e){
        detectFormChange();
		if(window.HAS_CHANGE){
			e.preventDefault();
            $("#modal-change-confirmation .back-confirmation").show();
            $("#modal-change-confirmation .save-confirmation").hide();
            $("#modal-change-confirmation .btn-real-back").attr('href', $(this).attr('href'));
			$("#modal-change-confirmation").modal();
		}
	});
    @endif

    @if(config('cms.admin.crud_confirmation_on_save'))
    $(document).on('submit', '.content form:not(.confirmed)', function(e){
        detectFormChange();
        e.preventDefault();
        if(window.HAS_CHANGE){
            $("#modal-change-confirmation .save-confirmation").show();
            $("#modal-change-confirmation .back-confirmation").hide();
            $("#modal-change-confirmation").modal();
        }
        else{
            toastr.warning("No change detected. No need to save this data");
        }
    });
    @endif

    $(document).on('click', '.btn-trigger-resend', function(e){
        e.preventDefault();
        $(".content form").addClass('confirmed').trigger('submit');
    });
});

function detectFormChange(){
    if(window.FORM_INIT_DATA != $(".content form").serialize()){
        window.HAS_CHANGE = true;
    }
    else{
        window.HAS_CHANGE = false;
    }
}
</script>
