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

//INCLUDE CONTROLLERS
include_once('common.php');
include_once('users.php');

class pages extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	/**
	 * REDIRECT TO PAGE ERROR 404 IF PAGE NOT EXIST
	 * @return redirect
	 * --------------------------------------------
	 */
	static function checkIfPageExist($page)
	{
		if( !file_exists(APPPATH.'/views/pages/'.$page.'.php') )
		{
			return show_404();
		}
	}

	public function page_loader()
	{
		return $this->load->view('templates/pages/loader');
	}

	public function site_header()
	{
		$this->load->view('templates/pages/site_header/site_header_open');
		$this->load->view('templates/pages/site_header/top_header');
		$this->load->view('templates/pages/site_header/main_header');
		$this->load->view('templates/pages/site_header/responsive_menu');
		$this->load->view('templates/pages/site_header/site_header_close');
	}

	/**
	 * DISPLAY INDEX VIEW PAGE
	 * @return data
	 * --------------------------------------------
	 */
	public function forgot_password($page)
	{
		return $this->load->view('pages/'.$page);
	}

	/**
	 * DISPLAY INDEX VIEW PAGE
	 * @return data
	 * --------------------------------------------
	 */
	public function login($page)
	{
		$common = new common;
		$users = new users;

		if( $common->check_login() ){
			$session_data = $this->session->userdata('logged_in');
			if( $session_data['is_admin'] == 'on' ){
				redirect('account/dashboard', 'refresh');
			}
		}
		return $users->login($page);
	}

	/**
	 * DISPLAY INDEX VIEW PAGE
	 * @return data
	 * --------------------------------------------
	 */
	public function home($page)
	{
		$this->page_loader();
		$this->site_header();

		return $this->load->view('pages/'.$page);
	}


	/**
	 * CHECK PAGE URI
	 * @return data
	 * --------------------------------------------
	 */
	public function view($page = 'home')
	{
		self::checkIfPageExist($page);
		$common = new common;
		$common->load_language();
		$common->display_header($page);

		switch ($page) {
			case 'forgot_password' : $this->forgot_password($page); break;
			case 'home'            : $this->home($page);            break;
			case 'login'           : $this->login($page);           break;
			default: $page = 'home'; $this->home($page);            break;
		}

		$common->display_footer();
	}
}
?>