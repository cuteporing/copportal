$(function() {
	var scroll = 0;
	// DO NOT MODIFY THIS, ALL FUNCTION WILL NOT
	// RUN IF THIS IS ERASED OR MODIFIED
	// --------------------------------------------
	function trim(str){
		var str=str.replace(/^\s+|\s+$/,'');
		return str;
	}

	// SHOW ERROR MESSAGE
	// --------------------------------------------
	function show_error_field(data){
		$.each(data, function(idx, obj){
			$('input[name="'+obj.input+'"]')
				.parents('.form-group')
				.find('.error')
				.html(obj.error_msg);
		});
	}

	// HIDE INDIVIDUAL ERROR MESSAGE
	// --------------------------------------------
	function hide_error_field(){
		$('.error').empty();
	}

	// CREATES AN ALERT MESSAGE
	// AVAILABLE CLASS:
	// - danger
	// - info
	// - success
	// - warning
	// --------------------------------------------
	function create_alert(msg, type){
		var alert_class = 'alert-'+type;
		var div         = document.createElement('div');

		div.className = 'alert alert-dismissable '+alert_class;

		switch(type){
			case 'danger' : icon_class = 'fa fa-ban';      break;
			case 'info'   : icon_class = 'fa fa-info';     break;
			case 'success': icon_class = 'fa fa-check';    break;
			case 'warning': icon_class = 'fa fa-warning';  break;
			default       : icon_class = 'fa fa-info';     break;
		}

		button = '<button type="button" class="close" aria-hidden="true" '+
						 'data-dismiss="alert">×</button>';
		icon = '<i class="'+icon_class+'"></i>';
		div.innerHTML = icon+button+msg;

		return div;
	}

	// SHOW GENERAL ALERT MESSAGE
	// --------------------------------------------
	function show_alert_msg(msg, type){
		$('.error_message').css('top', scroll+77+'px');
		$('.error_message').html( create_alert(msg, type) );

		$('.error_message').animate({ width: "30%" }, 500, function(){
			// $('.error_message .alert').show();
		});

		console.log("yeah");
		// $('.error_message').html( create_alert(msg, type) ).slideDown("fast");
	}

	// RESETS THE FORM
	// --------------------------------------------
	function form_reset(url){
		if( url == undefined ){ return; }

		url = url.split('/');
		var type = url[url.length-1];

		if( type == 'create' ){
			 $('form').find("input[type=text], textarea").val("");
			 $('.textarea').data("wysihtml5").editor.setValue('');
		}
	}

	$(window).scroll(function(){
		scroll = $(window).scrollTop();
		console.log(scroll);
	});

	// SENDS FORM DATA VIA AJAX
	// --------------------------------------------
	$('form').submit(function(e){
		e.preventDefault();
		hide_error_field();
		var form = $(this);

		$.post(
			form.attr('action'),
			form.serialize(),
			function (data) {
				var result = JSON.parse(data);
				console.log("RESULT: ");
				console.log("--------------------------------------");
				console.log( result );

				if( result.status_type == "error_field" ){
					//DISPLAY INDIVIDUAL INPUT ERROR
					show_error_field(result.data);
				}else if( result.status_type == "error" ){
					//DISPLAY GENERAL ERROR MESSAGE
					show_alert_msg(result.status_msg, 'danger');
				}else if( result.status_type == "success" ){
					//DISPLAY GENERAL SUCCESS MESSAGE
					show_alert_msg(result.status_msg, 'success');
					form_reset(form.attr('action'));
				}
			}
		)
	});

	$('[data-ajax="delete"]').click(function(e){
		e.preventDefault();
		var url = $(this).parent().attr('href');
		$.get( url, function( data ) {
			alert( data );
		});
	})
});
