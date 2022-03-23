@if (config('autocrud.asset_dependency.load_jquery'))
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endif
@if (config('autocrud.asset_dependency.load_bootstrap'))
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endif
@if (config('autocrud.asset_dependency.load_iconify'))
    <script src="https://code.iconify.design/2/2.0.4/iconify.min.js"></script>
@endif
@if (config('autocrud.asset_dependency.load_plugins'))
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'select2/select2.min.css') }}">

    <script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'plugins.js') !!}"></script>    
    <script src="{{ asset(config('autocrud.asset_url') . '/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset(config('autocrud.asset_url') . '/tinymce/jquery.tinymce.min.js') }}"></script>
    <script src="{{ asset(config('autocrud.asset_url') . '/dropzone-input.js') }}"></script>
@endif

<link rel="stylesheet" href="{{ asset(config('autocrud.asset_url') . 'datatable/datatables.min.css') }}">
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/DataTables/js/jquery.dataTables.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/Responsive/js/dataTables.responsive.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/FixedHeader/js/dataTables.fixedHeader.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/FixedColumns/js/dataTables.fixedColumns.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset(config('autocrud.asset_url') . 'datatable/ColReorder/js/dataTables.colReorder.min.js') !!}"></script>

<!-- AutoCRUD specific plugins -->
<script>
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

</script>