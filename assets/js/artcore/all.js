$(window).load(function() { // makes sure the whole site is loaded
	$('.loader-item').fadeOut(); // will first fade out the loading animation
	$('#pageloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
	$('body').delay(350).css({'overflow-y':'visible'});
})