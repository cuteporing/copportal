$(function() {
	$('form[enctype]').submit(function(e) {
		e.preventDefault();
		var url = $(this).attr('action');
		$('#files').html('');

		$.ajaxFileUpload({
			url             : url,
			secureuri       : false,
			fileElementId   : 'userfile',
			dataType: 'JSON',
			success : function (data)
			{
				var obj = jQuery.parseJSON(data);
				if(obj['status'] == 'success'){
					$('#files').html(obj['msg']);
					console.log(obj['img_data']);
				}else{
					$('#files').html('Some failure message');
				}
			}
		});
		return false;
	});
});