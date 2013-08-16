jQuery(document).ready(function($) {
	var numwidgets = $('#widgets-one .wrap .wrap div.widget').length;
	$('#widgets-one .wrap .wrap').addClass('cols-'+numwidgets);
	var numwidgets = $('#widgets-two .wrap .wrap div.widget').length;
	$('#widgets-two .wrap .wrap').addClass('cols-'+numwidgets);
	var numwidgets = $('#widgets-three .wrap .wrap div.widget').length;
	$('#widgets-three .wrap .wrap').addClass('cols-'+numwidgets);
});