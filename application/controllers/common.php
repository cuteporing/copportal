<?php
/*********************************************************************************
** The contents of this file are subject to the COPPortal
 * Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: KBVCodes
 * The Initial Developer of the Original Code is CodeIgniter.
 * Portions created by KBVCodes are Copyright (C) KBVCodes.
 * All Rights Reserved.
 *
 ********************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class common extends CI_controller
{
	private $bs_acct;
	private $bs_dark;

	public function __construct()
	{
		parent::__construct();
	}

	public function load_language()
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
			'meta'      => array(
				'DESCRIPTION'   => 'COP Tracer',
				'KEYWORDS'      => 'cop, training, seminar, outreach, program',
				'AUTHOR'        => 'KBVCodes, 2014', ),
			'NoImage'   => array(
				'FILE_PATH'     => 'assets/img/',
				'RAW_NAME'      => 'noPhoto-icon',
				'FILE_EXT'      => '.png'),
			'imgPath'   => array(
				'ANNOUNCEMENT'  => 'uploads/announcement/',
				'BANNER'        => 'uploads/banner/',
				'EVENT'         => 'uploads/event/',
				'GALLERY'       => 'uploads/gallery/',
				'GENERAL'       => 'uploads/', ),
			'imgConfig' => array(
				'ALLOWED_TYPES' => 'gif|jpg|png',
				'MAX_SIZE'      => '350',
				'MAX_WIDTH'     => '1024',
				'MAX_HEIGHT'    => '768',),
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
		//ADMIN PAGES
		$bs_acct = array(
			'announcements',
			'banner',
			'dashboard',
			'events',
			'gallery',
			'manage_beneficiary',
			'manage_users',
			'upload');

		//VIEW PAGES
		$bs_dark = array('login', 'forgot_password', 'register');

		$artcore = array('announcement', 'event', 'galleries', 'about');

		$artcore_home = array('home');

		if( in_array( strtolower($page), $bs_dark ) ){
			array_push($style, 'assets/css/bootstrap/bootstrap.min.css');
			array_push($style, 'assets/css/bootstrap/font-awesome.min.css');
			array_push($style, 'assets/css/bootstrap/AdminLTE.css');
		}elseif( in_array( strtolower($page), $bs_acct ) ){
			array_push($style, 'assets/css/bootstrap/bootstrap.min.css');
			array_push($style, 'assets/css/bootstrap/font-awesome-4.2.0/css/font-awesome.min.css');
			array_push($style, 'assets/css/bootstrap/ionicons-2.0.0/css/ionicons.min.css');
			array_push($style, 'assets/css/bootstrap/colorpicker/bootstrap-colorpicker.min.css');
			array_push($style, 'assets/css/bootstrap/daterangepicker/daterangepicker-bs3.css');
			array_push($style, 'assets/css/bootstrap/iCheck/all.css');
			array_push($style, 'assets/css/bootstrap/timepicker/bootstrap-timepicker.min.css');
			array_push($style, 'assets/css/bootstrap/AdminLTE.css');
			array_push($style, 'assets/css/bootstrap/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
		}elseif( in_array( strtolower($page), $artcore ) ){
			array_push($style, 'assets/css/artcore/roboto-slab.css');
			array_push($style, 'assets/css/artcore/roboto.css');
			array_push($style, 'assets/css/artcore/bootstrap.css');
			array_push($style, 'assets/css/artcore/font-awesome.css');
			array_push($style, 'assets/css/artcore/animate.css');
			array_push($style, 'assets/css/artcore/templatemo-misc.css');
			array_push($style, 'assets/css/artcore/templatemo-style.css');
		}elseif( in_array( strtolower($page), $artcore_home ) ) {
			array_push($style, 'assets/css/artcore/roboto-slab.css');
			array_push($style, 'assets/css/artcore/roboto.css');
			array_push($style, 'assets/css/artcore/bootstrap.css');
			array_push($style, 'assets/css/artcore/font-awesome.css');
			array_push($style, 'assets/css/artcore/animate.css');
			array_push($style, 'assets/css/artcore/style.css');
			array_push($style, 'assets/css/artcore/templatemo-misc.css');
			array_push($style, 'assets/css/artcore/templatemo-style.css');
		}else{
			array_push($style, 'assets/css/artcore/roboto-slab.css');
			array_push($style, 'assets/css/artcore/roboto.css');
			array_push($style, 'assets/css/artcore/bootstrap.css');
			array_push($style, 'assets/css/artcore/font-awesome.css');
			array_push($style, 'assets/css/artcore/animate.css');
			array_push($style, 'assets/css/artcore/templatemo-misc.css');
			array_push($style, 'assets/css/artcore/templatemo-style.css');
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
		$bs_acct = array(
			'announcements',
			'banner',
			'dashboard',
			'events',
			'gallery',
			'manage_beneficiary',
			'manage_users',
			'upload');

		$bs_dark = array('login', 'forgot_password', 'register');

		$artcore = array('announcement', 'event', 'about');

		$artcore_home = array('home');

		if( in_array( strtolower($page), $bs_dark ) ){
			array_push($script, 'assets/js/bootstrap/jquery.min.js');
			array_push($script, 'assets/js/bootstrap/bootstrap.min.js');
		}elseif( in_array( strtolower($page), $bs_acct ) ){
			array_push($script, 'assets/js/bootstrap/jquery.min.js');
			array_push($script, 'assets/js/bootstrap/bootstrap.min.js');
			array_push($script, 'assets/js/bootstrap/plugins/input-mask/jquery.inputmask.js');
			array_push($script, 'assets/js/bootstrap/plugins/input-mask/jquery.inputmask.date.extensions.js');
			array_push($script, 'assets/js/bootstrap/plugins/input-mask/jquery.inputmask.extensions.js');
			array_push($script, 'assets/js/bootstrap/plugins/daterangepicker/daterangepicker.js');
			array_push($script, 'assets/js/bootstrap/plugins/datepicker/bootstrap-datepicker.js');
			array_push($script, 'assets/js/bootstrap/plugins/timepicker/bootstrap-timepicker.min.js');
			array_push($script, 'assets/js/bootstrap/plugins/iCheck/icheck.min.js');
			array_push($script, 'assets/js/bootstrap/plugins/datatables/jquery.dataTables.js');
			array_push($script, 'assets/js/bootstrap/plugins/datatables/dataTables.bootstrap.js');
			array_push($script, 'assets/js/bootstrap/AdminLTE/app.js');
			array_push($script, 'assets/js/bootstrap/AdminLTE/dashboard.js');
			array_push($script, 'assets/js/bootstrap/AdminLTE/demo.js');
			array_push($script, 'assets/js/bootstrap/ckeditor.js');
			array_push($script, 'assets/js/bootstrap/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
			array_push($script, 'assets/js/bootstrap/all.js');
			array_push($script, 'assets/js/bootstrap/ajax.js');
		}elseif( in_array( strtolower($page), $artcore ) ){
			array_push($script, 'assets/js/artcore/vendor/jquery-1.11.0.min.js');
			array_push($script, 'assets/js/artcore/plugins.js');
			array_push($script, 'assets/js/artcore/main.js');
			array_push($script, 'assets/js/artcore/all.js');
		}elseif( in_array( strtolower($page), $artcore_home ) ){
			array_push($script, 'assets/js/artcore/vendor/jquery-1.11.0.min.js');
			array_push($script, 'assets/js/artcore/plugins.js');
			array_push($script, 'assets/js/artcore/main.js');
			array_push($script, 'assets/js/artcore/simplecalendar.js');
			array_push($script, 'assets/js/artcore/all.js');
		}else{
			array_push($script, 'assets/js/artcore/vendor/jquery-1.11.0.min.js');
			array_push($script, 'assets/js/artcore/plugins.js');
			array_push($script, 'assets/js/artcore/main.js');
			array_push($script, 'assets/js/artcore/all.js');
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
		//DARK BOOTSTRAP THEME
		$bs_acct = array(
			'announcements',
			'banner',
			'dashboard',
			'events',
			'gallery',
			'home',
			'manage_beneficiary',
			'manage_users',
			'upload');

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

			$time = str_replace(' ', ':', $time);
			$time = str_replace(':', ' ', $time);
			$time = explode(' ', $time);

			if( $time[2] == 'PM' ){
					$time[0] = $military_hr[$time[0]];
			}else{
				$time[2] = '00';
			}

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

	static function sort_month($input)
	{
		$output = array('All');

		foreach($input as $month) {
			$m = date_parse($month);
			$output[$m['month']] = $month;
		}
		ksort($output);

		return $output;
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

	static function display_date($date_start, $date_end)
	{
		if( $date_start == $date_end ){
			$date = common::format_date($date_start, 'F d, Y');
		}else{
			$date_start_arr = explode('-', $date_start);
			$date_end_arr   = explode('-', $date_end);

			//IF MONTH AND YEAR FOR STARTING AND ENDING DATE IS THE SAME,
			//AND DAY IS DIFF DISPLAY AS:
			// <M d-d, YYYY>
			// <Feb 11-13, 2015>
			if( $date_start_arr[0] == $date_end_arr[0] &&
				$date_start_arr[1] == $date_end_arr[1] ){

				$date = common::format_date($date_start, 'F ');
				$date.= $date_start_arr[2].'-'.$date_end_arr[2].', '.$date_start_arr[0];

			//IF MONTH OR YEAR FOR STARTING AND ENDING DATE IS DIFFERENT,
			//DISPLAY AS:
			// <M d, YYYY - M d, YYY>
			// <Feb 11, 2015 - Feb 11, 2016>
			}elseif( $date_start_arr[0] != $date_end_arr[0] ||
				$date_start_arr[1] != $date_end_arr[1] ){

				$date = common::format_date($date_start, 'F d, Y').' - ';
				$date.= common::format_date($date_end, 'F d, Y');
			}
		}

		return $date;
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

	public function show_404()
	{
		$this->load->view('templates/pages/content_wrapper_open');
		$this->load->view('error/artcore/error_404');
		$this->load->view('templates/pages/content_wrapper_close');
	}
}
?>

