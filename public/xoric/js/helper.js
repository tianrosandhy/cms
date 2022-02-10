// Show loading white screen
function showLoading(){
  $("#page-loader").fadeIn(250);
}

// Hide loading white screen
function hideLoading(){
  $("#page-loader").fadeOut(250);
}

// will enable/disable all <a> and <button>
function enableAllButtons(){
  $("a.js-disabled, button.js-disabled").each(function(){
    $(this).removeClass('js-disabled disabled').removeAttr('disabled');
  });
}

// will enable/disable all <a> and <button>
function disableAllButtons(){
  $("a:not([disabled]), button:not([disabled])").each(function(){
    $(this).addClass('js-disabled disabled').attr('disabled', 'disabled');
  });
}

// generate random alphanumeric string by length (int) parameter
function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

// Ajax error response handling helper
function error_handling(resp){
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
        toastr.error(v[0]);
      });
    }
  }
  else if(resp.type && resp.message){
    toastr.error(resp.message);
  }
  else{
    toastr.error('Sorry, we cannot process your last request');
  }
  hideLoading();
}

// Ajax error response handling helper
function errorHandling(){
  // just an alias name
  return error_handling();
}

// will convert "proper text" to "slugged-text"
function convertToSlug(Text){
  return Text
    .toLowerCase()
    .replace(/[^\w ]+/g,'')
    .replace(/ +/g,'-')
    ;
}
