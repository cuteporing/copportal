$(function() {
	//Datemask dd/mm/yyyy
	$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
	//Datemask2 mm/dd/yyyy
	$("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
	//Money Euro
	$("[data-mask]").inputmask();

	//Date range picker
	$('#reservation').daterangepicker();
	//Date range picker with time picker
	$('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
	//Date range as a button
	$('#daterange-btn').daterangepicker(
		{
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
				'Last 7 Days': [moment().subtract('days', 6), moment()],
				'Last 30 Days': [moment().subtract('days', 29), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
			},
		startDate: moment().subtract('days', 29),
		endDate: moment()
		},
		function(start, end) {
			$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		}
	);

	//iCheck for checkbox and radio inputs
	$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		checkboxClass: 'icheckbox_minimal',
		radioClass: 'iradio_minimal'
	});
	//Red color scheme for iCheck
	$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
		checkboxClass: 'icheckbox_minimal-red',
		radioClass: 'iradio_minimal-red'
	});
	//Flat red color scheme for iCheck
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		checkboxClass: 'icheckbox_flat-red',
		radioClass: 'iradio_flat-red'
	});
	//Timepicker
	$(".timepicker").timepicker({
		showInputs: false
	});
	//Data table
	$('#displayData').dataTable( { } );
	  var oTable;
	  oTable = $('#displayData').dataTable();

	  $('#status-control').change( function() { 
	        oTable.fnFilter( $(this).val() ); 
	   });
	$('#example2').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": false
	});
	//Clone elements
	$('[data-blind]').click(function(e){
		e.preventDefault();
		var elementClass = '.' + $(this).data('blind');
		var element      = $(elementClass);
		var button       = $(this);

		if( button.data('blind-sinsgle') !== "undefined" ){
			if( $( elementClass ).hasClass('hide') ){
				$( elementClass ).fadeIn('fast').removeClass('hide');
			}else{
				$( elementClass ).fadeIn('fast').addClass('hide');
			}
		}else{
			for (var i = 1; i < element.length; i++) {
				if( $( elementClass ).eq( i ).hasClass('hide') ){
					$( elementClass ).eq( i ).fadeIn('fast').removeClass('hide');

					if( i == element.length-1 ){
						button.hide();
					}
					return;
				}
			};
		}

	});



	sideBar();

	function sideBar(){
		var host = location.host;
		var url  = document.URL.split(location.host+'/copportal/account/')[1];
		var page = url.split('/')[0];
		var link = $('[data-page="'+page+'"]').parents('li');
		var hasDrop = link.hasClass('treeview')? true : false;

		link.addClass("active").slideDown('fast').siblings().removeClass('active');
		link.find('.fa.pull-right').removeClass('fa-angle-left').addClass('fa-angle-down');
		link.siblings().find('.fa.pull-right').removeClass('fa-angle-down').addClass('fa-angle-left');

		if( hasDrop )
			link.find('.treeview-menu').slideDown('fast');
	}
	var showModal = true;

	if (localStorage.getItem("modal_id") !== null) {
		$('[data-autoload]').trigger( "click" );
		if ("modal_id" in localStorage) localStorage.removeItem("modal_id");
	}


    jQuery('#print').click(function(e){
    	$("body").css("overflow", "hidden");
        jQuery('#print-template').removeClass('hide');
        window.print();
    	jQuery('#print-template').addClass('hide');
    });

    jQuery('select[name="user_kbn"]').on("change", function(){

    	if( $(this).val() == 30 || $(this).val() == 20 ){
				var textToFind = 'COP Department';
				var dd = document.getElementById('dept_id');
				for (var i = 0; i < dd.options.length; i++) {
				    if (dd.options[i].text === textToFind) {
				        dd.selectedIndex = i;
				        break;
				    }
				}
    	}else{
    		$('#dept_id option[selected="selected"]').each(
				    function() {
				        $(this).removeAttr('selected');
				    }
				);

    		jQuery("select[name='dept_id'] option:first").attr('selected','selected');
    	}
    });
});