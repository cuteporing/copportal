$(function() {
	$('form[enctype]').submit(function(e) {
		e.preventDefault();
		var _this    = $(this);
		var formData = new FormData(this);
		var url      = $(this).attr('action');
		var progressbar = $('.progress');
		var btn = _this.find('input[type="submit"]');

		btn.addClass('hide');
		progressbar.removeClass('hide');

		console.log( $('.progress').length );
		$.ajax({
			type: "POST",
			url: url,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
				var obj = jQuery.parseJSON(data);
				progressbar.find('.progress-bar').animate({ width: '100%' }, 1000, function(){ });
				
				console.log(obj);
			},
			error: function(data){
				//error function
				// $('.progress').hide();
				var obj = jQuery.parseJSON(data);
				console.log(obj);
			}
		});
	});
});