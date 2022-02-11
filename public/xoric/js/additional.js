$(function(){
  hideLoading();
  initPlugins();

  // init all site component handler
  InitCmsMenuAfterLoading();
  RegisterGlobalPopupHandler();
  RegisterGlobalYesNoToggle();
  RegisterGlobalDeleteConfirmButton();
  RegisterSlugMasterComponent();
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

// Switchery data toggle plugin handle
function RegisterGlobalYesNoToggle(){
  // yesno auto switcher
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
        conn : $(this).attr('data-conn'),
        table : $(this).attr('table'),
        field : $(this).attr('field'),
        value : $(this).prop('checked') ? 1 : 0
      },
      success : function(resp){
        if(typeof tb_data != 'undefined'){
          tb_data.ajax.reload(null, false);
        }
      },
      error : function(resp){
        instance.prop('checked', !instance.prop('checked'));
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


function RegisterSlugMasterComponent(){
  // slug master if exists
  if($("[slug-master]:not([saved-slug])").length){
    slug_target = $("[slug-master]").attr('data-target');
    if($(slug_target).length == 0){
      slug_target = slug_target + '-' + window.DEFAULT_LANGUAGE;
    }
    if($(slug_target).length){
      //give change event to this input
      first_load_slug = convertToSlug($(slug_target).val());
      $("[slug-master]").val(first_load_slug);

      $(slug_target).on('change', function(){
        slug_val = convertToSlug($(this).val());
        $("[slug-master]:not([saved-slug])").val(slug_val);
      });
    }
  }

  $(document).on('click', ".btn-change-slug", function(){
    $(this).addClass('btn-success');
    $(this).html('Set as Slug');
    $(this).removeClass('btn-secondary btn-change-slug');
    $(this).addClass('btn-save-slug');
    $("[slug-master]").addClass('manual').removeAttr('readonly').focus();
  });

  $(document).on('change', "[slug-master].manual", function(){
    $(this).attr('saved-slug', '1');
  });

  $("[slug-master]").on('keypress', function(e){
    if(e.which == 13){
      e.preventDefault();
      $(".btn-save-slug").click();
    }
  });

  $(document).on('click', '.btn-save-slug', function(){
    $("[slug-master]").attr('readonly', 'readonly').removeClass('manual');
    $(this).html('Change Manually');
    $(this).removeClass('btn-success btn-save-slug').addClass('btn-change-slug btn-secondary');
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



// you need to only call this method once
function initPlugins(){
  loadSwitchery();
  loadTouchspin();
  loadTinyMce();
  loadDatepicker();
  loadSelect2();
  loadFile();
  loadMask();
  simpleImage();
  // refreshDropzone();
}

// you can call this method everytime to reload the plugin dom
function refreshPlugins(){
  refreshSwitchery();
  loadTouchspin();
  loadTinyMce();
  loadDatepicker();
  loadSelect2();
  loadFile();
  loadMask();
  simpleImage();
  refreshDropzone();
}

function simpleImage(){
  $(".image_simple .image-closer").on('click', function(e){
    wrapper = $(this).closest(".image_simple");
    wrapper.find(".image-holder").fadeOut();
    wrapper.find("input").val('').fadeIn();
  });

  $(".image_simple input[type=file]").on('change', function(e){
    if($(this)[0].files.length > 0){
      //set image to dummy image
      wrapper = $(this).closest(".image_simple");

      var reader = new FileReader();
      reader.onload = (e) => {
        wrapper.find(".image-holder img").attr('src', e.target.result);
      };
      reader.readAsDataURL($(this)[0].files[0]);

      wrapper.find(".image-holder").fadeIn().css('display','inline-block');
      $(this).fadeOut();
    }
  });
}

function loadMask(){
  $(".input-currency").each(function(){
    str_decimal = '';
    decimal = parseInt($(this).attr('data-decimal'));
    if(decimal > 0){
      str_decimal += ',' + '0'.repeat(decimal);
    }
    $(this).mask('#.##0' + str_decimal, {reverse: true});  
  });
}

function loadFile(){
  $(".btn-add-file").on('click', function(e){
    e.preventDefault();
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
            // feather.replace();
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
    if($(this).is('.flatpickr-input, .flatpickr-input-active')){
      return; //gausa diinit ulang
    }

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
    if($(this).attr('data-monthpicker')){
      config.plugins = [
        new monthSelectPlugin({
          shorthand : true,
          dateFormat : 'Y-m-d',
        })
      ];
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
  $("[daterange-holder] input").each(function(){
    if($(this).is('.flatpickr-input, .flatpickr-input-active')){
      return;
    }
    config = {};

    if($(this).attr('data-mindate')){
      config.minDate = $(this).attr('data-mindate');
    }
    if($(this).attr('data-maxdate')){
      config.maxDate = $(this).attr('data-maxdate');
    }
    if($(this).attr('data-format')){
      config.altFormat = $(this).attr('data-format');
    }
  
    if($(this).attr('data-start-range')){
      config.onChange = function(selectedDates, dateStr, instance){
        end_date = $(instance.element).closest('[daterange-holder]').find('[data-end-range]');
        einstance = end_date[0]._flatpickr;
        einstance.set('minDate', dateStr);
        einstance.redraw();
      }
    }  
    if($(this).attr('data-end-range')){
      config.onChange = function(selectedDates, dateStr, instance){
        start_date = $(instance.element).closest('[daterange-holder]').find('[data-start-range]');
        sinstance = start_date[0]._flatpickr;
        sinstance.set('maxDate', dateStr);
        sinstance.redraw();
      }
    }  
    $(this).flatpickr(config);
  });
}


function refreshSwitchery(){
  $("[yesno]").each(function(){
    if(!$(this).is(':visible')){
      return;
    }
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

function loadSwitchery(){
  $("[yesno]").each(function(){
    if($(this).attr('applied')){
      return;
    }

    $(this).attr('applied', 1);
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



