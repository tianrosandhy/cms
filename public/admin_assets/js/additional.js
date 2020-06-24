$(function(){
	hideLoading();
	initPlugins();

  $(document).on('change', '[yesno][data-table-switch]', function(e){
    instance = $(this);
    $.ajax({
      url : window.BASE_URL + '/switcher-master',
      type : 'POST',
      dataType : 'json',
      data : {
        _token : window.CSRF_TOKEN,
        id : $(this).attr('data-id'),
        pk : $(this).attr('data-pk'),
        table : $(this).attr('table'),
        field : $(this).attr('field'),
        value : $(this).prop('checked') ? 1 : 0
      },
      success : function(resp){
        if(typeof tb_data != 'undefined'){
          tb_data.ajax.reload();
        }
      },
      error : function(resp){
        instance.prop('checked', !instance.prop('checked'));
      }
    });
  });

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


});

function showLoading(){
	$("#page-loader").fadeIn(250);
}

function hideLoading(){
	$("#page-loader").fadeOut(250);
}

function enableAllButtons(){
	$("a.js-disabled, button.js-disabled").each(function(){
		$(this).removeClass('js-disabled disabled').removeAttr('disabled');
	});
}

function disableAllButtons(){
	$("a:not([disabled]), button:not([disabled])").each(function(){
		$(this).addClass('js-disabled disabled').attr('disabled', 'disabled');
	});
}

function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}










function initPlugins(){
  loadSwitchery();
  loadTouchspin();
	loadTinyMce();
  loadDatepicker();
  loadSelect2();
  loadFile();
  refreshIcon();
}

function loadFile(){
  $(".btn-add-file").on('click', function(e){
    e.preventDefault();
    console.log($(this).closest('.input-file-holder').find('input[type=file]'));
    $(this).closest('.input-file-holder').find('input[type=file]').click();
  });

  $(".file-upload-controller").on('change', function(){
    list_files = $(this)[0].files;
    if(list_files.length == 0){
      //do nothing
    }
    else{
      if($(this).attr('data-max')){
        maxsizemb = parseInt($(this).attr('data-max'));
        maxsize = maxsizemb * 1024 * 1024;
        if($(this)[0].files[0].size > maxsize){
          alert('Mohon maaf, dokumen yang boleh diupload dibatasi hanya berukuran max ' + maxsizemb + 'MB saja.');
          obj_input.val('');
          return;
        }
      }

      showLoading();
      obj_input = $(this);
      input_container = $(this).closest('.input-file-holder');
      real_input = $(this).closest('.input-file-holder').find('.real-input-holder');
      var fd = new FormData;
      var files = $(this)[0].files[0];
      fd.append('document', files);
      $.ajax({
        url : window.BASE_URL + '/post-document',
        type : 'POST',
        dataType : 'json',
        data : fd,
        contentType : false,
        processData : false,
        success : function(resp){
          if(resp.type == 'success'){
            obj_input.val('');
            real_input.val(resp.savepath);
            preview = '<div class="item btn-group mb-2"><a title="Click to Download" href="'+resp.download_url+'" download class="btn btn-primary">'+resp.filename+'</a><a href="#" class="btn btn-danger"><i data-feather="x"></i></a></div>';
            input_container.find('.preview-holder').html(preview);
            feather.replace();
          }
          else{
            alert(resp.message);
          }
          hideLoading();
        },
        error : function(resp){
          error_handling(resp);
        }
      });


    }
  });
}

function loadSelect2(){
  $(".select2").select2();
}

function loadDatepicker(){
  $("[data-datepicker]").each(function(){
    config = {
      "altInput" : true,
      "mode" : "single",
    };
    if($(this).attr('data-mindate')){
      config.minDate = $(this).attr('data-mindate');
    }
    if($(this).attr('data-maxdate')){
      config.maxDate = $(this).attr('data-maxdate');
    }
    if($(this).attr('data-format')){
      config.altFormat = $(this).attr('data-format');
    }
    $(this).flatpickr(config);
  });
  $("[data-timepicker]").each(function(){
    config = {
      enableTime : true,
      noCalendar : true,
      dateFormat : "H:i",
      time_24hr : true
    };
    if($(this).attr('data-format')){
      config.dateFormat = $(this).attr('data-format');
    }
    $(this).flatpickr(config);
  });
  $("[data-datetimepicker]").each(function(){
    config = {
      enableTime : true,
      dateFormat : "Y-m-d H:i",
      time_24hr : true
    };
    if($(this).attr('data-format')){
      config.altFormat = $(this).attr('data-format');
    }
    $(this).flatpickr(config);
  });


  //daterange function
  $("[daterange-holder] [data-start-range]").flatpickr({
    onChange : function(selectedDates, dateStr, instance){
      end_date = $(instance.element).closest('[daterange-holder]').find('[data-end-range]');
      einstance = end_date[0]._flatpickr;
      einstance.set('minDate', dateStr);
      einstance.redraw();
    }
  });
  $("[daterange-holder] [data-end-range]").flatpickr({
    onChange : function(selectedDates, dateStr, instance){
      start_date = $(instance.element).closest('[daterange-holder]').find('[data-start-range]');
      sinstance = start_date[0]._flatpickr;
      sinstance.set('maxDate', dateStr);
      sinstance.redraw();
    }
  });
}

function refreshIcon(){
  // init featherjs
  if(typeof feather != 'undefined'){
    feather.replace();
  }
}

function loadSwitchery(){
  $("[yesno]").each(function(){
    new Switchery($(this)[0], {
      size : 'small'
    });

    if($(this).attr('data-target')){
      $(this).on('change', function(){
        chk = $(this).prop('checked');
        if(chk){
          cond = 1;
        }
        else{
          cond = 0;
        }
        $($(this).attr('data-target')).val(cond);
      });
    }
  });  
}

function loadTouchspin(){
  $("[touchspin]").each(function(){
    config = {};
    if($(this).attr('min')){
      config.min = $(this).attr('min');
    }
    if($(this).attr('max')){
      config.max = $(this).attr('max');
    }
    if($(this).attr('step')){
      config.step = $(this).attr('step');
    }
    if($(this).attr('decimal')){
      config.decimals = $(this).attr('decimal');
    }
    if($(this).attr('prefix')){
      config.prefix = $(this).attr('prefix');
    }
    if($(this).attr('postfix')){
      config.postfix = $(this).attr('postfix');
    }
    if($(this).attr('data-vertical')){
      config.verticalbuttons = true;
    }
    $(this).TouchSpin(config);
  });  
}






function loadTinyMce(){
  tinymce.init({
    selector : 'textarea[data-tinymce]',
    height : 400, 
    theme : 'modern',
    plugins : 'storeimage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help code',
    toolbar1: 'formatselect | storeimage | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent  | removeformat code',
    image_advtab: true,
//    images_upload_url : BASE_URL + '/api/store-images',
    relative_urls : false,
    remove_script_host : false,
    convert_urls : true,
    branding : false,

    menu: {
      file: {title: 'File', items: 'newdocument'},
      edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext selectall searchreplace'},
      insert: {title: 'Insert', items: 'storeimage codesample link media image table | template hr pagebreak nonbreaking insertdatetime'},
      view: {title: 'View', items: 'code visualaid fullscreen'},
      format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
      table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
      tools: {title: 'Tools', items: 'spellchecker code'}
    },

    images_upload_handler: function (blobInfo, success, failure) {
      var xhr, formData;

      xhr = new XMLHttpRequest();
      xhr.withCredentials = false;
      xhr.open('POST', BASE_URL + '/media/upload-tinymce');
      xhr.setRequestHeader('X-CSRF-TOKEN', window.CSRF_TOKEN);

      xhr.onload = function() {
        var json;
        if (xhr.status != 200) {
          failure('HTTP Error: ' + xhr.status);
          return;
        }
        json = JSON.parse(xhr.responseText);
        if (!json || typeof json.location != 'string') {
          failure('Invalid JSON: ' + xhr.responseText);
          return;
        }
        success(json.location);
      };

      formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());

      xhr.send(formData);
    }

  });
}

function deletePrompt(url, callback){
  dtcl = callback || '';

  output = '<p>Are you sure? Once deleted, you will not be able to recover the data</p><button class="btn btn-primary" data-dismiss="modal">Cancel</button> <button class="btn btn-danger" onclick="ajaxUrlProcess(\''+url+'\' '+ (dtcl ? ',\''+dtcl+'\'' : '') +')">Yes, Delete</button>';
  toastr.info(output);
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
          tb_data.ajax.reload();
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

function error_handling(resp){
  if(resp.responseJSON){ //kalo berbentuk xhr object, translate ke json dulu
    resp = resp.responseJSON;
  }

  if(resp.errors){
    $.each(resp.errors, function(k, v){
      toastr.error(v[0]);
    });
  }
  else if(resp.type && resp.message){
    toastr.error(resp.message);
  }
  else{
    toastr.error('Sorry, we cannot process your last request');
  }
  hideLoading();
}

