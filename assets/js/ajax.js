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
				.css('border-color', 'red')
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

	function hide_error_highlight(){
		$('input').each(function() {
			$(this).removeAttr('style');
		});
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
		$('.error_message').css({
			'right'  : '-1000px',
			'top'    : scroll+77+'px'});
		$('.error_message').html( create_alert(type) );
		$('.alert-dismissable')
			.css({
				'height'      : 'auto',
				'padding-left': '30px',
				'margin-left' : '15px',
				'position'    : 'relative'
			})
			.append(msg);

		$('.error_message').animate({ right: '0px'}, 500, function(){
			$('.error_message').delay(1500).animate({
				right: '-1000px'
			}, 1000, function(){
				$('.error_message').removeAttr('style');
				$('.error_message').find('.close').click();
			});
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
		hide_error_highlight();
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
				}else if( result.status_type == "warning" ){
					//DISPLAY GENERAL ERROR MESSAGE
					show_alert_msg(result.status_msg, 'warning');
				}else if( result.status_type == 'error_confirm' ){
					//DISPLAY ALERT CONFIRM MESSAGE
					show_alert_confirm(result.status_msg, false);
				}else if( result.status_type == "success" ){
					//DISPLAY GENERAL SUCCESS MESSAGE
					show_alert_msg(result.status_msg, 'success');
					form_reset(form.attr('action'));
				}else if( result.status_type == "refresh" ){
					//RELOAD PAGE
					location.reload();
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

	// REMOVE BORDER ERROR HIGHLIGHT WHEN FOCUS
	// --------------------------------------------
	$('input').focus(function(){
		$(this).removeAttr('style').next().html('');
	});

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
	});


	$("[data-autocomplete]").keyup(function() {
		var _this       = $(this);
		var url         = $(this).data('link');
		var keyword     = $(this).val();
		var result_id   = $(this).data('autocomplete-id');
		var result_list = $('#'+result_id);
		var name        = _this.attr('name');

		var MIN_LENGTH  = 3;
		console.log( url );
		//CHECK IF NO. OF CHARS IS MORE THAN 3 BEFORE MAKING AN AJAX REQUEST
		if (keyword.length >= MIN_LENGTH) {
			$.get( url, { keyword: keyword } )
			
			.done(function( data ) {
				console.log( data );
				result_list.html('');
				var results = jQuery.parseJSON(data);

				//SET ALL THE RESULT IN A LIST
				$(results).each(function(key, item) {
					if( item.label == keyword ){
						$('input[name="'+name+'_id"]').val(item.value);
					}
					result_list.append('<li class="item" data-value="'+
						item.value+'">' + item.label + '</li>');
				})

				//ADD THE SELECTED OPTION TO THE SEARCH BOX
				$('#'+result_id+' .item').click(function() {
					var text  = $(this).html();
					var value = $(this).data('value');
					_this.val(text);
					$('input[name="'+name+'_id"]').val(value);
				})
			});
		} else {
			result_list.html('');
		}
	});

	$("[data-autocomplete]").blur(function(){
		var result_list = $('#'+$(this).data('autocomplete-id'));
		result_list.fadeOut(500);
	})
	.focus(function() {
		var name = $(this).attr('name');
		var result_list = $('#'+$(this).data('autocomplete-id'));

		$('input[name="'+name+'_id"]').val('');
		result_list.show();
	});

});
