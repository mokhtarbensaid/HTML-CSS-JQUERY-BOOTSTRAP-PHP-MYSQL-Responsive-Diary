$(document).ready(function(){


    // Convert Password field to text field on Hover

    $('.fa-eye').click(function(){

    	$('.password').attr('type','text');
    	$('.fa-eye').fadeOut();
    	$('.fa-eye-slash').fadeIn();
    });

    $('.fa-eye-slash').click(function(){

    	$('.password').attr('type','password');
    	$('.fa-eye-slash').fadeOut();
    	$('.fa-eye').fadeIn();

    });

    // Hide Placeholder on form focus
	$('[placeholder]').focus(function(){

		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', '');

	}).blur(function(){

		$(this).attr('placeholder', $(this).attr('data-text'));
		
	});

    $('.search-toggle').click(function(){

        $(this).toggleClass('selected').next('.search-form').fadeToggle(200);

    });

    //    $('.nav-item').click(function () {
    // $(this).addClass('active').siblings().removeClass('active');
  // });
$(function() {
  $('.nav-item[href^="/' + location.pathname.split("/")[1] + '"]').addClass('active');
});

});