$(function(){
  hideLoading();

  // init all site component handler
  InitCmsMenuAfterLoading();
  RegisterGlobalPopupHandler();
  RegisterGlobalDeleteConfirmButton();
  RegisterAjaxForm();
});

// This function is called on first load, so the menu will be updated to its right structure
function InitCmsMenuAfterLoading(){
  //remove blank sidebar
  $(".sub-menu").each(function(){
    if($(this).find('li').length == 0){
      $(this).closest('li').remove();
    }
  });

  //additional tweak : auto show second & third level of navigation
  $("li.mm-active>ul.sub-menu").addClass('mm-collapse mm-show').css('height', 'auto');
}

// Register [data-popup] handler so we can call ajax to popup via this helper
function RegisterGlobalPopupHandler(){
  $(document).on('click', "[data-popup]", function(e){
    e.preventDefault();
    showLoading();
    $.ajax({
      url : $(this).attr('href'),
      dataType : 'html',
      success : function(resp){
        hideLoading();
        $("#global-popup .modal-body").html(resp);
        popupTitle = '';
        if($("#global-popup .modal-body .ajax-holder[data-title]").length > 0){
          popupTitle = $("#global-popup .modal-body .ajax-holder[data-title]").attr('data-title');
        }
        $("#global-popup .modal-header .title").html(popupTitle);
        $("#global-popup").modal('show');
        // dijeda 500ms agar plugin benar2 diload (fix karena ada jeda fadein modal)
        setTimeout(function(){
          refreshPlugins();
        }, 500);
      },
      error : function(resp){
        error_handling(resp);
        hideLoading();
      }
    });
  });

  $(document).on('click', "[data-popup-lg]", function(e){
    e.preventDefault();
    showLoading();
    $.ajax({
      url : $(this).attr('href'),
      dataType : 'html',
      success : function(resp){
        hideLoading();
        $("#global-popup-lg .modal-body").html(resp);
        popupTitle = '';
        if($("#global-popup-lg .modal-body .ajax-holder[data-title]").length > 0){
          popupTitle = $("#global-popup-lg .modal-body .ajax-holder[data-title]").attr('data-title');
        }
        $("#global-popup-lg .modal-header .title").html(popupTitle);
        $("#global-popup-lg").modal('show');
        // dijeda 500ms agar plugin benar2 diload (fix karena ada jeda fadein modal)
        setTimeout(function(){
          refreshPlugins();
        }, 500);
      },
      error : function(resp){
        error_handling(resp);
        hideLoading();
      }
    });
  });  
}



var deletePrompt;
function RegisterGlobalDeleteConfirmButton(){
  deletePrompt = (url, callback) => {
    dtcl = callback || '';

    output = '<p>Are you sure? Once deleted, you will not be able to recover the data</p><button class="btn btn-primary" data-dismiss="modal">Cancel</button> <button class="btn btn-danger" onclick="ajaxUrlProcess(\''+url+'\' '+ (dtcl ? ',\''+dtcl+'\'' : '') +')">Yes, Delete</button>';
    toastr.info(output);
  }
  // prompt on delete button click
  $(document).on("click", ".delete-button", function(e){
    e.preventDefault();
    delete_url = $(this).attr('href');
    delete_url = delete_url || $(this).attr('data-target');
    removedDiv = $(this).closest('.close-target');
    if($(this).attr('data-callback')){
      deletePrompt(delete_url, $(this).attr('data-callback'));
    }
    else{
      deletePrompt(delete_url);
    }
  });  
}

function ajaxUrlProcess(url, callback, ajax_type){
  ajax_type = ajax_type || 'POST';
  cll = function(){};
  if(callback){
    cll = callback;
  }

  $.ajax({
    url : url,
    type : ajax_type,
    dataType : 'json',
    data : {
      _token : window.CSRF_TOKEN
    },
    success : function(resp){
      if(resp.type == 'success'){
        toastr.success(resp.message);

        var fn = window[cll];
        if(typeof fn == 'function'){
          fn();
        }

        if(removedDiv != 'undefined'){
          removedDiv.fadeOut(300);
          setTimeout(function(){
            removedDiv.remove();
          }, 300);
        }

        if(typeof tb_data != 'undefined'){
            $.each(tb_data, function(k, itm){
                itm.ajax.reload(null, false);
            });
        }
      }
      else if(resp.type == 'error'){
        toastr.error(resp.message);
      }
    },
    error : function(resp){
      error_handling(resp);
    }
  });
}

function RegisterAjaxForm(){
  // global form.ajax-form handle
  $(document).on('submit', 'form.ajax-form', function(e){
    e.preventDefault();
    showLoading();

    fd = new FormData($(this)[0]);
    inputFiles = $(this).find('input[type=file]');
    if(inputFiles.length > 0){
      inputFiles.each(function(){
        name = $(this).attr('name');
        if(typeof $(this)[0].files[0] != 'undefined'){
          fd.append(name, $(this)[0].files[0]);
        }
      });
    }

    $.ajax({
      url : $(this).attr('action'),
      type : $(this).attr('method'),
      data : fd,
      processData : false,
      contentType : false,
    }).done(resp => {
      hideLoading();
      if(resp.message){
        if(resp.type == 'success'){
          toastr.success(resp.message);
        }
        else{
          toastr.error(resp.message);
        }
      }
      if (typeof tb_data != 'undefined') {
        $.each(tb_data, function(k, itm){
            itm.ajax.reload(null, false);
        });
        $(".modal").modal('hide');
        return;
      }
      if(resp.redirect){
        showLoading();
        window.location = resp.redirect;
      }
    }).fail(err => {
      hideLoading();
      error_handling(err);
    });
  });  
}
