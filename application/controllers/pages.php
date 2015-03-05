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
include_once('announcements.php');
include_once('artcore_pagination.php');
include_once('banner.php');
include_once('common.php');
include_once('events.php');
include_once('gallery.php');
include_once('users.php');

class pages extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('artcore_model');
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
			return true;
		}
	}

	/**
	 * GET LOADER
	 * @return page
	 * --------------------------------------------
	 */
	public function page_loader()
	{
		return $this->load->view('templates/pages/loader');
	}

	/**
	 * GET TOP NAVIGATION DATA
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_top_nav()
	{
		return $this->artcore_model->get_top_nav();
	}

	/**
	 * GET SITE HEADER
	 * @return Array
	 * --------------------------------------------
	 */
	public function site_header($search_link='', $show_swipper_arrow = false)
	{
		$common = new common;
		$is_loggedin = $common->check_login();

		if( $is_loggedin === true ){
			$users = new users;
			$users->get_login_info();
			$session_data = $this->session->userdata('logged_in');
			$data['logged_in_user'] = $session_data['first_name'].' '.$session_data['last_name'];
		}


		$data['top_nav']       = $this->get_top_nav();
		$data['swipper_arrow'] = $show_swipper_arrow;
		$data['search_link']   = $search_link;

		$this->load->view('templates/pages/site_header/site_header_open');
		$this->load->view('templates/pages/site_header/top_header');
		$this->load->view('templates/pages/site_header/main_header', $data);
		$this->load->view('templates/pages/site_header/responsive_menu', $data);
		$this->load->view('templates/pages/site_header/site_header_close');
	}

	/**
	 * DISPLAY ANNOUNCEMENTS
	 * @return data
	 * --------------------------------------------
	 */
	public function announcement($page)
	{
		$announcements = new announcements;
		$this->page_loader();
		$this->site_header('announcement/title/');

		return $announcements->view_artcore($page);
	}

	/**
	 * DISPLAY EVEMTS
	 * @return data
	 * --------------------------------------------
	 */
	public function event($page)
	{
		$event = new events;
		$this->page_loader();
		$this->site_header('event/title/');

		return $event->view_artcore($page);
	}

	/**
	 * DISPLAY INDEX VIEW PAGE
	 * @return data
	 * --------------------------------------------
	 */
	public function home($page)
	{
		$banner = new banner;
		$this->page_loader();
		$this->site_header('event/title/', true);
		$data['banner'] = $banner->get_artcore_banner();

		return $this->load->view('pages/'.$page, $data);
	}

	/**
	 * DISPLAY GALLERY
	 * @return data
	 * --------------------------------------------
	 */
	public function galleries($page)
	{
		$galleries = new gallery;
		$this->page_loader();
		$this->site_header('galleries/title/');
		$this->load->view('templates/pages/content_wrapper_open');
		$this->load->view('pages/'.$page);
		$this->load->view('templates/pages/content_wrapper_close');
	}

	/**
	 * DISPLAY ABOUT
	 * @return data
	 * --------------------------------------------
	 */
	public function about($page)
	{
		$galleries = new gallery;
		$this->page_loader();
		$this->site_header('galleries/title/');

		return $galleries->view_artcore($page);
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
	 * CHECK PAGE URI
	 * @return data
	 * --------------------------------------------
	 */
	public function view($page = 'home')
	{
		if( !self::checkIfPageExist($page) ){
			$common = new common;
			$common->load_language();
			$common->display_header($page);

			switch ($page) {
				case 'announcement'    : $this->announcement($page);    break;
				case 'event'           : $this->event($page);           break;
				case 'galleries'       : $this->galleries($page);       break;
				case 'home'            : $this->home($page);            break;
				case 'login'           : $this->login($page);           break;
				case 'about'           : $this->about($page);           break;
				default: $page = 'home'; $this->home($page);            break;
			}

			$common->display_footer();
		}else{
			$common = new common;
			$common->load_language();
			$common->display_header($page);
			$this->page_loader();
			$this->site_header();
			$common->show_404();
			$common->display_footer();
		}
	}
}
?>