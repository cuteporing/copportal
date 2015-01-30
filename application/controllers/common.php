<?php
/*********************************************************************************
** The contents of this file are subject to the ______________________
 * Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: ______________________
 * The Initial Developer of the Original Code is CodeIgniter.
 * Portions created by KBVCodes are Copyright (C) KBVCodes.
 * All Rights Reserved.
 *
 ********************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class common extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function loadLanguage()
	{
		$this->lang->load('labels', 'english');
		$this->lang->load('error', 'english');
	}

	/**
	 * GET CONSTANTS
	 * @param String, $type
	 * @param String, $request
	 * @return Array
	 * --------------------------------------------
	 */
	static function get_constants($type, $request)
	{
		$constants = array(
			'meta' => array(
				'DESCRIPTION' => 'COP Tracer',
				'KEYWORDS'    => 'cop, training, seminar, outreach, program',
				'AUTHOR'      => 'KBVCodes, 2014', ),
			'imgPath' => array(
				'BANNER' => '/upload/banner/', ),
		);

		return $constants[$type][$request];
	}

	/**
	 * GET STYLESHEETS
	 * @param String, $page
	 * @return Array, $style
	 * --------------------------------------------
	 */
	static function get_style_sheet($page)
	{
		$style = array();

		//DARK BOOTSTRAP THEME
		$bs_acct = array('home','announcements', 'dashboard', 'events', 'manage_beneficiary', 'manage_users');
		$bs_dark = array('login', 'forgot_password', 'register');

		if( in_array( strtolower($page), $bs_dark ) ){
			array_push($style, 'assets/css/bootstrap.min.css');
			array_push($style, 'assets/css/font-awesome.min.css');
			array_push($style, 'assets/css/AdminLTE.css');
		}elseif( in_array( strtolower($page), $bs_acct ) ){
			array_push($style, 'assets/css/bootstrap.min.css');
			array_push($style, 'assets/css/font-awesome-4.2.0/css/font-awesome.min.css');
			array_push($style, 'assets/css/ionicons-2.0.0/css/ionicons.min.css');
			array_push($style, 'assets/css/colorpicker/bootstrap-colorpicker.min.css');
			// array_push($style, 'assets/css/morris/morris.css');
			// array_push($style, 'assets/css/jvectormap/jquery-jvectormap-1.2.2.css');
			array_push($style, 'assets/css/daterangepicker/daterangepicker-bs3.css');
			array_push($style, 'assets/css/iCheck/all.css');
			array_push($style, 'assets/css/timepicker/bootstrap-timepicker.min.css');
			array_push($style, 'assets/css/AdminLTE.css');
			array_push($style, 'assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
		}

		return $style;
	}

	/**
	 * GET JAVASCRIPT | JQUERY
	 * @param String, $page
	 * @return Array, $script
	 * --------------------------------------------
	 */
	static function get_scripts($page)
	{
		$script = array();

		//DARK BOOTSTRAP THEME
		$bs_acct = array('announcements', 'dashboard', 'events', 'manage_beneficiary', 'manage_users');
		$bs_dark = array('login', 'forgot_password', 'register');

		if( in_array( strtolower($page), $bs_dark ) ){
			array_push($script, 'assets/js/jquery.min.js');
			array_push($script, 'assets/js/bootstrap.min.js');
		}elseif( in_array( strtolower($page), $bs_acct ) ){
			array_push($script, 'assets/js/jquery.min.js');
			array_push($script, 'assets/js/bootstrap.min.js');
			array_push($script, 'assets/js/jquery-ui.min.js');
			// array_push($script, 'assets/js/raphael-min.js');
			// array_push($script, 'assets/js/plugins/morris/morris.min.js');
			// array_push($script, 'assets/js/plugins/sparkline/jquery.sparkline.min.js');
			// array_push($script, 'assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');
			// array_push($script, 'assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');
			// array_push($script, 'assets/js/plugins/jqueryKnob/jquery.knob.js');
			array_push($script, 'assets/js/plugins/input-mask/jquery.inputmask.js');
			array_push($script, 'assets/js/plugins/input-mask/jquery.inputmask.date.extensions.js');
			array_push($script, 'assets/js/plugins/input-mask/jquery.inputmask.extensions.js');
			array_push($script, 'assets/js/plugins/daterangepicker/daterangepicker.js');
			array_push($script, 'assets/js/plugins/datepicker/bootstrap-datepicker.js');
			array_push($script, 'assets/js/plugins/timepicker/bootstrap-timepicker.min.js');
			array_push($script, 'assets/js/plugins/iCheck/icheck.min.js');
			array_push($script, 'assets/js/plugins/datatables/jquery.dataTables.js');
			array_push($script, 'assets/js/plugins/datatables/dataTables.bootstrap.js');
			array_push($script, 'assets/js/AdminLTE/app.js');
			array_push($script, 'assets/js/AdminLTE/dashboard.js');
			array_push($script, 'assets/js/AdminLTE/demo.js');
			array_push($script, 'assets/js/ckeditor.js');
			array_push($script, 'assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
			array_push($script, 'assets/js/all.js');
			array_push($script, 'assets/js/ajax.js');
		}

		return $script;
	}

	/**
	 * GET CLASS FOR HTML BODY
	 * @param String, $page
	 * @return <body> tag
	 * --------------------------------------------
	 */
	static function get_body_class($page)
	{
		$bs_acct = array('announcements', 'dashboard', 'events', 'manage_beneficiary', 'manage_users');
		$bs_dark = array('login', 'forgot_password', 'register');

		//DARK BOOTSTRAP THEME
		if( in_array( strtolower($page), $bs_dark ) ){
			return element_tag('body', array('class'=>'bg-black'));
		}elseif( in_array( strtolower($page), $bs_acct ) ){
			return element_tag('body', array('class'=>'skin-blue'));
		}
	}

	/**
	 * META TAGS
	 * @return data
	 * --------------------------------------------
	 */
	public function display_header($page)
	{
		$data['title']       = ucfirst(str_replace('_', ' ', $page));
		$data['description'] = self::get_constants('meta', 'DESCRIPTION');
		$data['keywords']    = self::get_constants('meta', 'KEYWORDS');
		$data['author']      = self::get_constants('meta', 'AUTHOR');
		$data['style']       = self::get_style_sheet($page);
		$data['script']      = self::get_scripts($page);
		$data['body']        = self::get_body_class($page);

		return $this->load->view('templates/header', $data);
	}

	/**
	 * DISPLAY ALL DATA IN FOOTER
	 * @return data
	 * --------------------------------------------
	 */
	public function display_footer()
	{
		return $this->load->view('templates/footer');
	}

	/**
	 * GET CURRENT DATETIME
	 * @return date (Y-m-d H:i:s)
	 * --------------------------------------------
	 */
	static function get_today()
	{
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();

		return mdate($datestring, $time);
	}

	/**
	 * FORMAT DATE
	 * @param String, $datetime
	 * @param String, $format
	 * @return String, $formatted
	 * --------------------------------------------
	 */
	static function format_date($datetime, $format='Y-m-d')
	{
		$date = new DateTime($datetime);
		$formatted =  $date->format($format);
		return $formatted;
	}

	/**
	 * FORMAT TIME
	 * @param String, $time
	 * @param String, $format
	 * @return String, $new_time
	 * --------------------------------------------
	 */
	static function format_time($time, $format='H:s:i')
	{
		if( $format == 'H:s:i' ){
			$military_hr = array(
				'01' => 13,
				'02' => 14,
				'03' => 15,
				'04' => 16,
				'05' => 17,
				'06' => 18,
				'07' => 19,
				'08' => 20,
				'09' => 21,
				'10' => 22,
				'11' => 23,
				'12' => 00
				);

			$time = str_replace(':', ' ', $time);
			$time = explode(' ', $time);

			if( $time[2] == 'PM' )
					$time[0] = $military_hr[$time[0]];

			$time[2] = '00';
			$new_time = implode(':', $time);
			return $new_time;
		}
	}

	/**
	 * DISPLAYS AN ERROR MESSAGE
	 * @param String, $msg
	 * @return <p>
	 * --------------------------------------------
	 */
	static function error_msg($msg)
	{
		return p($msg, array('class'=>'error'));
	}


	/**
	 * CHECKS IF THERE IS A LOGGED IN USER
	 * @return redirect
	 * --------------------------------------------
	 */
	public function check_login()
	{
		if( $this->session->userdata('logged_in') ){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * CREATES ICON
	 * @param Array, $icon
	 * @return String, <i>
	 * --------------------------------------------------------
	 */
	static function create_icon($icon)
	{
		if( ! is_array($icon) ){ return ''; }

		return i('&nbsp', $icon);
	}


	/**
	 * ENCODE INTO JSON FORMAT FOR AJAX RESPONSE
	 * @param Integer, $status
	 * @param String, $msg
	 * @param Array, $data
	 * @return <object>
	 * --------------------------------------------------------
	 */
	static function response_msg($status_code, $status_type, $msg, $data=''){
		$response = array(
			'status_code'=> $status_code,
			'status_type'=> $status_type,
			'status_msg' => $msg,
			);
		if ( is_array($data) ) { $response['data'] = $data; }

		return json_encode($response);
	}

}

function set_values($value){
	if( isset( $value ) ){
		return $value;
	}
}
?>

