@extends ('core::layouts.master')

@push ('style')
<link rel="stylesheet" href="{{ admin_asset('libs/jquery-nestable/jquery.nestable.min.css') }}">
<link rel="stylesheet" href="{{ admin_asset('libs/jquery-nestable/navigation.css') }}">
@endpush

@section ('content')
	@include ('core::components.header-box', [
		'control_buttons' => [
			[
				'url' => route('admin.navigation.index'),
				'label' => 'Back',
				'icon' => 'arrow-left'
			],
		]
	])

<div class="card mt-3 nav-holder">
	<div class="card-header bg-primary text-white">
		{{ $data->group_name }}
	</div>
	<div class="card-body">
		@if(has_access('admin.navigation_item.store'))
		<a href="#" class="btn btn-primary mb-3 btn-add-navigation" data-toggle="modal" data-target="#navigationModal"><i class="fa fa-plus"></i> Add New Menu</a>
		@endif

		<div class="navigation-list-holder">
			@include ('navigation::partials.navigation-item-list')
		</div>
	</div>
</div>
@stop

@push ('modal')
	@include ('navigation::partials.modal-crud')
	<template id="default-form-content">
		@include ('navigation::partials.navigation-item-form')
	</template>
@endpush

@push ('script')
<script src="{{ admin_asset('libs/jquery-nestable/jquery.nestable.min.js') }}"></script>
<script>
$(function(){
	loadNestable();

	$(document).on('change', '.action-toggle', function(){
		initAfterLoadModal();
	});

	$(document).on('click', '.btn-update-menu', function(){
		target_id = $(this).attr('data-navigation-item-id');
		$("#page-loader").show();
		$.ajax({
			url : window.BASE_URL + '/navigation-form/' + target_id,
			type : 'GET',
			dataType : 'html',
			success : function(resp){
				$("#navigationModal .default-modal-content").html(resp);
				$("#navigationModal").modal('show');
				$("#page-loader").hide();
				initAfterLoadModal();
			},
			error : function(resp){
				toastr['error']('Sorry, we cannot process your request right now');
				$("#page-loader").hide();
			}
		});
	});

  $(document).on('click', '.btn-add-navigation', function(){
      $("#navigationModal .default-modal-content").html(
          $("#default-form-content").html()
      );
      initAfterLoadModal();
  });


	$(document).on('click', '.reorder-btn', function(){
		reorder_data = window.JSON.stringify($(".nav-nestable").nestable('serialize'));
		$("#page-loader").show();
		$.ajax({
			url : window.BASE_URL + '/navigation-item/reorder/{{ $id }}',
			type : 'POST',
			dataType : 'json',
			data : {
				_token : window.CSRF_TOKEN,
				data : reorder_data
			},
			success : function(resp){
				$(".reorder-btn").slideUp();
				hideLoading();
				refreshNestable();
			},
			error : function(resp){
				$("#page-loader").hide();
				toastr('error')['Sorry, we cannot reorder the data right now. Please try again later'];
			}
		});
	});

	initAfterLoadModal();

});

function afterDeleteNavigation(){
	//after delete called
	refreshNestable();
}

function refreshNestable(){
	$("#page-loader").show();
	$(".navigation-list-holder").html('');
	$.ajax({
		url : window.BASE_URL + '/navigation-refresh/{{ $id }}',
		dataType : 'html',
		success : function(resp){
			$(".navigation-list-holder").html(resp);
			loadNestable();
			$("#page-loader").hide();
		},
		error : function(resp){
			swal('error', ['Sorry, we cannot refresh the navigation']);
			$("#page-loader").hide();
		}
	});
}

function loadNestable(){
	$(".nav-nestable").each(function(){
		$(this).nestable({
			maxDepth : parseInt($(this).attr('data-level'))
		}).on('change', function(){
			serializeGroup($(this).attr('data-group'));
		});
		serializeGroup($(this).attr('data-group'), true);
	});	
}

function initAfterLoadModal(){
	sel = $(".action-toggle").find('option:selected');
	$(".action-type-value").slideUp();
	$(".action-type-value[data-type='"+sel.attr('data-target')+"']").slideDown();

	$(".select-icon").select2({
		templateSelection : formatIcons,
		templateResult : formatIcons,
	});
}

function formatIcons(icon){
	return $('<span><i class="fa fa-fw '+ $(icon.element).data('icon') +'"></i> '+ icon.text +'</span>');
}

function serializeGroup(group_id, first_try){
	first_try = first_try || false;

	inputInstance = $("input[name='order-data'][data-group='"+group_id+"']");
	oldVal = inputInstance.val();

	json = $(".nav-nestable[data-group='"+group_id+"']").nestable('serialize');
	jsonData = window.JSON.stringify(json);
	inputInstance.val(jsonData);

	if(!first_try){
		if(oldVal != jsonData){
			//ada perubahan order, munculkan tombol show reorder button
			$(".reorder-btn[data-group='"+group_id+"']").slideDown();
		}
	}
}	
</script>
@endpush