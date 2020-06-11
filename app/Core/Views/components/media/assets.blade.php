<style>
#media-modal{
	overflow:hidden;
}
.media-item{
	object-fit:cover;
}
.dz-default.dz-message{
	padding:1em;
	font-size:120%;
	text-align:center;
	cursor:pointer;
}	
.btn.active{
	background:#ddd;
}
.media-image-thumb{
	display:block;
	padding:.5em;
	margin-bottom:1em;
	opacity:1;
	text-align:center;
}
.media-image-thumb:hover{
	opacity:.75;
}
.media-image-thumb.selected{
	background:#25c2e3;
	color:#fff;
}

.media-image-container{
	position:relative;
}

.media-image-container .cols{
	float:left;
	margin:.5em;
}



#media-modal{
	overflow:hidden;
}
.filemanager-content{
	position:relative;
	overflow:hidden;
}
.filemanager-detail{
	position:absolute;
	top:1em;
	right:-500px;
	max-width:300px;
	transition:.3s ease;
	-moz-transition:.3s ease;
	-o-transition:.3s ease;
	-webkit-transition:.3s ease;
	-ms-transition:.3s ease;
}
.filemanager-detail.opened{
	top:1em;
	right:1em;
}
.filemanager-detail .closer{
	position:absolute;
	right:.25em;
	top:.25em;
	cursor:pointer;
	width:40px;
	height:40px;
	line-height:40px;
	text-align: center;;
	background:transparent;
	color:#000;
	border-radius:50%;
	transition:.3s ease;
	-moz-transition:.3s ease;
	-webkit-transition:.3s ease;
	-ms-transition:.3s ease;
	-o-transition:.3s ease;
}
.filemanager-detail .closer:hover{
	background:#aaa;
	color:#fff;
	transform:rotate(180deg);
	-moz-transform:rotate(180deg);
	-webkit-transform:rotate(180deg);
	-o-transform:rotate(180deg);
}

.media-image-container{
	transition:.3s ease;
	-moz-transition:.3s ease;
	-o-transition:.3s ease;
	-webkit-transition:.3s ease;
	-ms-transition:.3s ease;
}
.media-image-container.opened{
	margin-right:300px;
}

@media (max-width:768px){
	.media-image-container.opened{
		margin-right:0;
	}
	.filemanager-detail.opened{
		max-width:inherit;
		width:100%;
		background:#fff;
		height:100%;
	}
}
</style>


<!-- popup content -->
<div class="modal fade" tabindex="-1" role="dialog" id="media-modal">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-xl-3 col-6 mb-2">
						<a href="#" class="btn btn-white bg-white trigger-upload-tab">
							<i class="icon" data-feather="upload"></i> <span class="d-none d-sm-inline-block">Upload Image</span>
						</a>
					</div>
					<div class="col-xl-3 d-none d-lg-block d-xl-block"></div>
					<div class="col-xl-3 col-6 text-right">
						<div class="btn-group">
							<button type="button" class="refresh-button btn btn-info" title="Refresh">
								<i class="icon" data-feather="refresh-cw"></i>
							</button>
							<button type="button" class="sort-asc btn btn-white" title="Older First">
								<i class="icon" data-feather="arrow-down"></i>
							</button>
							<button type="button" class="sort-desc btn btn-white desc" title="Older Last">
								<i class="icon" data-feather="arrow-up"></i>
							</button>
						</div>
					</div>
					<div class="col-xl-3 col-6">
						<form action="" class="media-search">
							<div class="input-group">
								<input type="search" autocomplete="off" class="form-control" name="keyword" id="media-search-keyword" placeholder="Search Image">
								<div class="input-group-append">
									<button type="button" class="search-button btn btn-secondary" title="Search">
										<i class="icon" data-feather="search"></i>
									</button>
								</div>						
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="card-body filemanager-content">

			</div>
			<div class="card-body filemanager-upload" style="display:none;">
				<?php
				$max_size = (file_upload_max_size() / 1024 /1024);
				?>
				<div class="dropzone custom-dropzone dz-clickable mydropzone" data-hash="" upload-limit="{{ intval($max_size) }}" data-target="{{ route('admin.media') }}"></div>
				<div>
					<span style="opacity:.5; font-size:.7em; padding:0 .75em;">Maximum Upload Size : {{ number_format($max_size, 2) }} MB</span>
				</div>
				<div class="my-3">
					<a href="#" class="trigger-filemanager btn btn-sm btn-secondary"><< Back to Images Gallery</a>
				</div>
			</div>
		</div>

      </div>
    </div>
  </div>
</div>



<script src="{{ admin_asset('libs/dropzone/dropzone.min.js') }}"></script>

<!-- for media input -->
<script>
var FILEMANAGER_PAGE = 1;
$(function(){
	$(document).on('click', ".trigger-upload-image", function(){
		//set data-hash to filemanager modal
		hash = $(this).closest(".input-image-holder").attr('data-hash');
		$("#media-modal").attr('data-hash', hash);
		$("#media-modal [data-hash]").attr('data-hash', hash);
		$("#media-modal").modal('show');
	});

	$(document).on('click', '.input-image-holder .remove-image', function(e){
		e.preventDefault();
		par = $(this).closest('.input-image-holder');
		par.find('.listen-image-upload').val('');

		mi = par.find('img.media-item');
		mi.attr('src', mi.attr('data-fallback'));
	});

});
</script>


<!-- for file manager -->
<script>
Dropzone.autoDiscover = false;
function initImageDropzone(){
	$(".mydropzone").each(function(){
		var ajaxurl = $(this).data("target");
		var dropzonehash = $(this).attr('data-hash');
		var maxsize = $(this).attr('upload-limit');
		if(maxsize.length == 0){
			maxsize = 2;
		}

		if($(this).find('.dz-default').length == 0){
			$(this).dropzone({
				url : ajaxurl,
				acceptedFiles : 'image/*',
				maxFilesize : maxsize,
				sending : function(file, xhr, formData){
					formData.append("_token", window.CSRF_TOKEN);
					disableAllButtons();
				},
				init : function(){
					this.on("success", function(file, data){
						data = window.JSON.parse(file.xhr.responseText);
						this.removeFile(file);
						enableAllButtons();
					});

					this.on("queuecomplete", function(){
						this.removeAllFiles();
						enableAllButtons();
						afterFinishUpload();
					});
					this.on("error", function(file, err, xhr){
						this.removeAllFiles();
						enableAllButtons();
					});
				}
			});		
		}
	});		
}
$(function(){

	loadFileManager(1, true);

	$(document).on('click', ".trigger-upload-tab", function(){
		gotoUpload();
	});
	$(document).on('click', ".trigger-filemanager", function(){
		gotoFilemanager();
	});

	// trigger utk menjalankan refresh file manager
	$(document).on('click', '.btn.sort-desc', function(){
		$(this).addClass('active');
		$(".btn.sort-asc").removeClass('active');
		loadFileManager();
	});
	$(document).on('click', '.btn.sort-asc', function(){
		$(this).addClass('active');
		$(".btn.sort-desc").removeClass('active');
		loadFileManager();
	});
	$(document).on('submit', '.media-search', function(e){
		e.preventDefault();
		loadFileManager();
	});
	$(document).on('click', '.refresh-button', function(){
		loadFileManager();
	});

	$(document).on('click', '.filemanager-detail .closer', function(e){
		e.preventDefault();
		hideImageDetail();
	});

	if( 
		$(".mydropzone").length || 
		$(".mydropzone-multiple").length
	){
		initImageDropzone();
	}

	$(document).on('click', '.media-image-thumb', function(e){
		e.preventDefault();
		loadImageDetail($(this));
	});

	$(document).on('click', '.filemanager-select-final', function(e){
		e.preventDefault();
		response = {};
		response.thumb = $(".filemanager-thumb-selection").val();
		response.id = $(".filemanager-thumb-selection").attr('data-id');
		response.path = $(".filemanager-thumb-selection").attr('data-path');

		//output format : JSON stringify & url path
		string_response = window.JSON.stringify(response);
		hash_target = $("#media-modal").attr('data-hash');
		if($(".input-image-holder[data-hash='"+hash_target+"']").length){
			input_target = $(".input-image-holder[data-hash='"+hash_target+"']");
			input_target.find('.listen-image-upload').val(string_response);
			input_target.find('.media-item').attr('src', $(".holder-image").attr('src'));
		}

		//output format : string path utk wysiwyg
		//later

		resetModalFilemanager();

	});
});

function resetModalFilemanager(){
	$("#media-modal").modal('hide');
	$("#media-modal").find('.opened').removeClass('opened');
	$("#media-modal").find('.selected').removeClass('selected');
}

function gotoUpload(){
	$(".filemanager-content").slideUp();
	$(".filemanager-upload").slideDown();
	$(".trigger-upload-tab").fadeOut();
}

function gotoFilemanager(reload){
	reload = reload || true;
	$(".filemanager-content").slideDown();
	$(".filemanager-upload").slideUp();
	$(".trigger-upload-tab").fadeIn();

	if(reload){
		loadFileManager();
	}
}

function afterFinishUpload(){
	gotoFilemanager(true);
}

function loadFileManager(page, ignore_loading){
	page = page || 1;
	ignore_loading = ignore_loading || false;

	if(!ignore_loading){
		showLoading();
	}

	keyword = $("#media-search-keyword").val();
	sort_dir = $(".btn.sort-asc").hasClass('active') ? 'asc' : 'desc';
	$.ajax({
		url : window.BASE_URL + '/file-manager',
		type : 'POST',
		dataType : 'html',
		data : {
			keyword : keyword,
			sort_dir : sort_dir,
			page : page
		},
		success : function(resp){
			$(".filemanager-content").html(resp);
			hideLoading();
		},
		error : function(resp){
			toastr['error']('Sorry, we cannot process your request right now');
			hideLoading();
		}
	});
}

function loadImageDetail(click_instance){
	$(".media-image-container .selected").removeClass('selected');
	click_instance.addClass('selected');
	thumb_src = click_instance.attr('data-src');
	media_id = click_instance.attr('data-media-id');
	filename = click_instance.attr('data-filename');
	path = click_instance.attr('data-origin');
	media_url = window.STORAGE_URL + path;

	$(".filemanager-detail img").attr('src', thumb_src);
	$(".filemanager-detail .holder-title").html(filename);
	$(".filemanager-detail .holder-url").attr('src', media_url);
	$(".filemanager-detail .filemanager-thumb-selection").attr('data-id', media_id);
	$(".filemanager-detail .filemanager-thumb-selection").attr('data-path', path);
	$(".filemanager-content, .media-image-container, .filemanager-detail").addClass('opened');
	feather.replace();	
}

function hideImageDetail(){
	$(".filemanager-content, .media-image-container, .filemanager-detail").removeClass('opened');
	$(".media-image-container .selected").removeClass('selected');
}
</script>


<!-- for input -->
<script>
	
</script>