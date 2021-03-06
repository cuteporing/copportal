$(window).load(function() { // makes sure the whole site is loaded
	$('.loader-item').fadeOut(); // will first fade out the loading animation
	$('#pageloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
	$('body').delay(350).css({'overflow-y':'visible'});

	sideBar();

	function sideBar(){
		var host = location.host;
		var url  = document.URL.split(location.host+'/copportal/')[1];
		var page = url.split('/')[0];
		var nav  = $('[data-page="'+page+'"]').parents('li');

		if( page == '' ){
				$('[data-page="home"]').parents('li').addClass('active');
				return;
		}

		nav.addClass('active');
	}


	$('#search-input').keydown(function(e) {
		if(e.keyCode == 13){
			var action = $('#search-forms').attr('action');
			$('#search-forms').attr('action', action+$('#search-input').val());
		}

	});

	setInterval(function(){
		$('.main-header-left .arrow-right').click();
	}, 5000);


	setTimeout(function(){
		$('.vision').removeAttr('style');
		$('.mission').removeAttr('style');
		$('.objectives').removeAttr('style');
	}, 400);

});