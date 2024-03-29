$(function(){
    initPlugins();
});

function initPlugins(){
  loadDatepicker();
  loadSwitchery();
  loadTouchspin();
  loadTinyMce();
  loadSelect2();
  loadFile();
  loadMask();
  simpleImage();
  loadLanguageToggle();
  registerSlugMasterComponent();
  registerGlobalYesNoToggle();
}

// you can call this method everytime to reload the plugin dom
function refreshPlugins(){
  loadDatepicker();
  refreshSwitchery();
  loadTouchspin();
  loadTinyMce();
  loadSelect2();
  loadFile();
  loadMask();
  simpleImage();
  loadLanguageToggle();
  registerGlobalYesNoToggle();
  registerSlugMasterComponent();
  refreshDropzone();
}

// Switchery data toggle plugin handle
function registerGlobalYesNoToggle(){
  // yesno auto switcher
  $('[yesno][data-table-switch]').on('change', function(e){
    instance = $(this);
    $.ajax({
      url : $(this).attr('data-href'),
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
            $.each(tb_data, function(k, itm){
                itm.ajax.reload(null, false);
            });
        }
      },
      error : function(resp){
        instance.prop('checked', !instance.prop('checked'));
      }
    });
  });  
}

function registerSlugMasterComponent(){
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

  $(".btn-change-slug").on('click', function(){
    $(this).addClass('btn-success');
    $(this).html('Set as Slug');
    $(this).removeClass('btn-secondary btn-change-slug');
    $(this).addClass('btn-save-slug');
    $("[slug-master]").addClass('manual').removeAttr('readonly').focus();
  });

  $("[slug-master].manual").on('change', function(){
    $(this).attr('saved-slug', '1');
  });

  $("[slug-master]").on('keypress', function(e){
    if(e.which == 13){
      e.preventDefault();
      $(".btn-save-slug").click();
    }
  });

  $('.btn-save-slug').on('click', function(){
    $("[slug-master]").attr('readonly', 'readonly').removeClass('manual');
    $(this).html('Change Manually');
    $(this).removeClass('btn-success btn-save-slug').addClass('btn-change-slug btn-secondary');
  });  
}

function loadLanguageToggle() {
    $('.autocrud-language-toggle span[data-lang]').on('click', function(e){
        e.preventDefault();
        selectedLang = $(this).attr('data-lang');
        $('.custom-form-group .input-language[data-lang="'+selectedLang+'"]').slideDown(200);
        $('.custom-form-group .input-language:not([data-lang="'+selectedLang+'"])').slideUp(200);
        $(".autocrud-language-toggle span[data-lang='"+selectedLang+"']").addClass('active');
        $(".autocrud-language-toggle span:not([data-lang='"+selectedLang+"'])").removeClass('active');

        cfg = $(this).closest('.custom-form-group');
        setTimeout(function(){
            cfg.find('input.form-control:visible').focus();
        }, 250);
    });
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

      showAutocrudLoading();
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
          hideAutocrudLoading();
        },
        error : function(resp){
          autoCrudErrorHandling(resp);
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

// AutoCRUD Ajax error response handling helper
function autoCrudErrorHandling(resp, fallbackMsg){
  if(resp.responseJSON){ //kalo berbentuk xhr object, translate ke json dulu
    resp = resp.responseJSON;
  }

  if(resp.errors){
    $.each(resp.errors, function(k, v){
      toastr.error(v[0]);
    });
  }
  else if(resp.error){
    if(typeof resp.error == 'string'){
      toastr.error(resp.error);
    }
    else{
      $.each(resp.error, function(k, v){
        toastr.error(v);
      });
    }
  }
  else if(resp.type && resp.message){
    toastr.error(resp.message);
  }
  else{
    if (typeof fallbackMsg == 'string' && fallbackMsg.length > 0) {
        toastr.error(fallbackMsg);
    } else {
        toastr.error('Sorry, we cannot process your last request');
    }
  }
  hideAutocrudLoading();
}

function showAutocrudLoading(){
    $("body").addClass('autocrud-loading');
}

function hideAutocrudLoading(){
    $("body").removeClass('autocrud-loading');
}

// will convert "proper text" to "slugged-text"
function convertToSlug(Text){
  return Text
    .toLowerCase()
    .replace(/[^\w ]+/g,'')
    .replace(/ +/g,'-')
    ;
}
