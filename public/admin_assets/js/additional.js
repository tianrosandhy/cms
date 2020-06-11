$(function(){
	hideLoading();
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