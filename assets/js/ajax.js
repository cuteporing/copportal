$(function() {
	var scroll = 0;
	// DO NOT MODIFY THIS, ALL FUNCTION WILL NOT
	// RUN IF THIS IS ERASED OR MODIFIED
	// --------------------------------------------
	function trim(str){
		var str=str.replace(/^\s+|\s+$/,'');
		return str;
	}

	function show_alert_confirm(msg, is_form) {
		var x;
		( confirm( msg ) == true )?
			x = 'yes' : x = 'no';

		console.log(x);
		$('#confirm').val( x );
		if( x == 'yes' && is_form === false){
			$(":submit").click();
		}else if( is_form === true ){
			return x;
		}
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
	function create_alert(type){
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
		// div.innerHTML = icon+button+msg;
		div.innerHTML = icon+button;

		return div;
	}

	// SHOW GENERAL ALERT MESSAGE
	// --------------------------------------------
	function show_alert_msg(msg, type){
		$('.error_message').css('top', scroll+77+'px');
		$('.error_message').html( create_alert(type) );
		$('.alert-dismissable').css({
			'height'      : '52px',
			'padding-left': '30px',
			'margin-left' : '15px',
			'position'    : 'relative'
		});
		$('.error_message').animate({ width: "30%" }, 500, function(){
			$('.alert-dismissable').append(msg);
			$('.alert-dismissable').css('height', 'auto');
		});
	}

	// HIDE GENERAL ALERT MESSAGE
	// --------------------------------------------
	function hide_alert_msg(){
		$('[data-dismiss="alert"]').click();
	}

	// RESETS THE FORM
	// --------------------------------------------
	function form_reset(url){
		if( url == undefined ){ return; }

		url = url.split('/');
		var type = url[url.length-1];

		if( type == 'create' ){
			$('form').find("input[type=text], textarea").val("");
			if( $('[data-wysihtml5]').length > 0 ){
				$('.textarea').data("wysihtml5").editor.setValue('');
			}
		}
	}

	// ONSCROLL EVENT
	// --------------------------------------------
	$(window).scroll(function(){
		scroll = $(window).scrollTop();
		//IF THERE IS AN ALERT MESSAGE BOX
		if( $('.alert-dismissable').length > 0 ){
			$('.error_message').css('top', scroll+77+'px');
		}
	});

	// SENDS FORM DATA VIA AJAX
	// --------------------------------------------
	$('form').submit(function(e){
		e.preventDefault();
		hide_alert_msg();
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
				}else if( result.status_type == 'error_confirm' ){
					//DISPLAY ALERT CONFIRM MESSAGE
					show_alert_confirm(result.status_msg, false);
				}else if( result.status_type == "success" ){
					//DISPLAY GENERAL SUCCESS MESSAGE
					show_alert_msg(result.status_msg, 'success');
					form_reset(form.attr('action'));
				}
			}
		)
	});

	// REMOVE DATA FROM A TABLE LIST
	// --------------------------------------------
	function remove_data_table(el){
		el.closest('tr').remove();
	}

	// REMOVE DISPLAYED DATA DEPENDING ON THE TYPE
	// --------------------------------------------
	function remove_data(el){
		var type= el.data('del-type');
		switch(type) {
			case 'table': remove_data_table(el); break;
			default : remove_data_table(el);     break;
		}
	}

	// DELETE DATA VIA AJAX
	// --------------------------------------------
	$('[data-ajax="delete"]').click(function(e){
		e.preventDefault();
		var url = $(this).parent().attr('href');
		var _this= $(this);

		if( show_alert_confirm(
			'Are you sure you want to delete?', true) === 'no' ){
			return;
		}

		$.get( url, function( data ) {
			var result = JSON.parse(data);
			console.log("RESULT: ");
			console.log("--------------------------------------");
			console.log( result );

			if( result.status_type='success' ){
				//DISPLAY GENERAL SUCCESS MESSAGE
				show_alert_msg(result.status_msg, 'success');
				//REMOVE DISPLAYED DATA
				remove_data(_this);
			}else{
				//DISPLAY GENERAL ERROR MESSAGE
				show_alert_msg(result.status_msg, 'danger');
			}
		});
	})
});
