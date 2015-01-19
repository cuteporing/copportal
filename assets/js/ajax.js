$(function() {
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
		console.log('create_alert');
		var alert_class = 'alert-'+type;
		var div         = document.createElement('div');

		div.className = 'alert alert-dismissable alert-'+type;

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

	function show_alert_msg(msg, type){
		$('.error_message').html( create_alert(msg, type) ).slideDown("fast");
	}

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
				}
			}
		)
	});
});
