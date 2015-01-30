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

//INCLUDE CONTROLLERS
include_once('common.php');
include_once('announcements.php');
include_once('box.php');
include_once('dashboard.php');
include_once('events.php');
include_once('manage_beneficiary.php');
include_once('manage_users.php');
include_once('sidebar.php');
include_once('status_box.php');
include_once('users.php');

class account extends CI_controller
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
		if( !file_exists(APPPATH.'/views/account/'.$page.'.php') )
		{
			return show_404();
		}
	}

/**
	 * DISPLAYS SYSTEM LOGO
	 * @return Link
	 * --------------------------------------------
	 */
	public function logo()
	{
		return anchor('dashboard', 'COP Portal', array('class'=>'logo'));
	}

	/**
	 * DISPLAYS THE LOGO AND TOP NAVIGATION BAR
	 * @return String
	 * --------------------------------------------
	 */
	public function header()
	{
		$header = $this->logo();
		$header.= $this->top_nav();

		$header = create_tag('header', $header, array('class'=>'header'));

		return $header."\n";
	}

	/**
	 * DISPLAYS TOP NAVIGATION BAR
	 * @return String
	 * --------------------------------------------
	 */
	public function top_nav()
	{
		$toggle_attr = array(
			'class'=>'navbar-btn sidebar-toggle',
			'data-toggle'=>'offcanvas',
			'role'=>'button'
		);

		$navbar_attr = array(
			'class'=>'navbar navbar-static-top',
			'role'=>'navigation'
		);

		$navigation = span('Toggle navigation', array('class'=>'sr-only'));
		$navigation.= span('', array('class'=>'icon-bar'));
		$navigation.= span('', array('class'=>'icon-bar'));
		$navigation.= span('', array('class'=>'icon-bar'));

		$navigation = anchor('', $navigation, $toggle_attr);
		$navigation.= $this->top_nav_list();

		$navigation = $navigation.end_tag('nav')."\n";
		$navigation = element_tag('nav', $navbar_attr).$navigation;

		return $navigation;
	}

	/**
	 * DISPLAYS TOP NAVIGATION BAR LIST
	 * @return ul
	 * --------------------------------------------
	 */
	public function top_nav_list($nav_list = '')
	{
		$nav_list.= $this->dropdown_user();

		$nav_list = create_tag('ul', $nav_list, array('class'=>'nav navbar-nav'));

		$nav_list = div($nav_list, array('class'=>'navbar-right'));

		return $nav_list;
	}

	/**
	 * DISPLAYS TOP NAVIGATION BAR DROPDOWN USER
	 * @return li
	 * --------------------------------------------
	 */
	public function dropdown_user()
	{
		$users = new users;

		$users->get_login_info();
		
		$session_data = $this->session->userdata('logged_in');

		//ATTRIBUTES FOR ELEMENTS
		$attribute = array(
			'caret'      => array('class'=>'caret'),
			'btn_flat'   => array('class'=>'btn btn-default btn-flat'),
			'gylph_user' => array('class'=>'glyphicon glyphicon-user'),
			'user_menu'  => array('class'=>'dropdown user user-menu'),
			'drop_menu'  => array('class'=>'dropdown-menu'),
			'drop_toggle'=> array('class'=>'dropdown-toggle',
								'data-toggle'=>'dropdown'),
			'user_img'   => array('class'=>'img-circle',
								'src'  =>$session_data['imagename'],
								'alt'  =>'User Image'),
			'user_header'=> array('class'=>'user-header bg-light-blue'),
			'user_footer'=> array('class'=>'user-footer'),
			'pull_left'  => array('class'=>'pull-left'),
			'pull_right' => array('class'=>'pull-right')
		);

		$user_name = $session_data['first_name'].' '.$session_data['last_name'];
		$user_icon = i('&nbsp;', $attribute['gylph_user']);

		//DISPLAYS NAME LINK FOR DROPDOWN IN TOP NAV
		$display_name = i('&nbsp;', $attribute['caret']);
		$display_name = span($user_name.$display_name);
		$display_name = anchor('', $display_name, $attribute['drop_toggle']);


		$date_entered = common::format_date($session_data['date_entered'], 'M. Y');

		$users = new users;
		//CONTAINS THE MEMBER'S PROFILE IMG AND NAME
		$user_header = create_tag('small', 'Member since '.$date_entered);
		$user_header = p('Welcome - '.$user_name.$user_header);
		$user_header = $user_header.$users->get_user_img(
			$attribute['user_img'], $session_data['gender']);
		$user_header = li($user_header, $attribute['user_header']);

		//LINKS FOR USER FOOTER
		$profile_btn = anchor('', 'Profile', $attribute['btn_flat']);
		$profile_btn = div($profile_btn, $attribute['pull_left']);
	
		$signout_btn = anchor('logout', 'Signout', $attribute['btn_flat']);
		$signout_btn = div($signout_btn, $attribute['pull_right']);

		$user_footer = li($profile_btn.$signout_btn, $attribute['user_footer']);

		$drop_menu = create_tag('ul', $user_header.$user_footer, $attribute['drop_menu']);

		$list = $display_name.$drop_menu;
		$list = li($list, $attribute['user_menu']);

		return $list;
	}

	/**
	 * BREAD CRUMBS
	 * @param String, $page
	 * @return data
	 * --------------------------------------------
	 */
	static function bread_crumbs($page = '')
	{
		$attribute = array(
				'active'=> array('class'=>'active'),
				'icon'  => array('class'=>'fa fa-dashboard'),
				'ol'    => array('class'=>'breadcrumb'),
			);

		$home   = common::create_icon($attribute['icon']);
		$home   = anchor('account/dashboard', $home. 'Home');
		$current= li($page);

		$li = li($home, $attribute['active']);
		$li.= $current;

		return create_tag('ol', $li, $attribute['ol']);
	}

	/**
	 * DISPLAY THE PAGE CONTENT HEADER AND
	 * @param String, Page
	 * @return data
	 * --------------------------------------------
	 */
	static function content_header($page = '')
	{
		$page = str_replace('_', ' ', $page);
		$title        = heading($page.create_tag('small','Control panel'), '1');
		$bread_crumbs = self::bread_crumbs($page);

		return create_tag('section', $title.$bread_crumbs,
						array('class'=>'content-header'));
	}

	/**
	 * ANNOUNCEMENTS
	 * @param String, $page
	 * @param String, $sidebar
	 * @return page
	 * --------------------------------------------
	 */
	public function announcements($page, $sidebar)
	{
		$announcements = new announcements;
		$header  = $this->header();
		$c_header= self::content_header(ucfirst($page));

		return $announcements->view($page,$header,$sidebar, $c_header);
	}

	/**
	 * DISPLAY INDEX VIEW PAGE
	 * @return data
	 * --------------------------------------------
	 */
	public function dashboard($page, $sidebar)
	{
		$dashboard = new dashboard;
		$header  = $this->header();
		$c_header= self::content_header(ucfirst($page));

		return $dashboard->view($page,$header,$sidebar, $c_header);
	}

	/**
	 * EVENTS
	 * @param String, $page
	 * @param String, $sidebar
	 * @return page
	 * --------------------------------------------
	 */
	public function events($page, $sidebar)
	{
		$events  = new events;

		$header  = $this->header();
		$c_header= self::content_header(ucfirst($page));

		return $events->view($page,$header,$sidebar, $c_header);
	}

	/**
	 * MANAGE BENEFICIARY
	 * @param String, $page
	 * @param String, $sidebar
	 * @return page
	 * --------------------------------------------
	 */
	public function manage_beneficiary($page, $sidebar)
	{
		$manage_beneficiary  = new manage_beneficiary;

		$header  = $this->header();
		$c_header= self::content_header(ucfirst($page));

		return $manage_beneficiary->view($page,$header,$sidebar, $c_header);
	}

	/**
	 * TOP NAVIGATION DROPDOWN THAT CONTAINS THE
	 * USER INFORMATION
	 * @param String, $page
	 * @param String, $sidebar
	 * @return dropdown
	 * --------------------------------------------
	 */
	public function manage_users($page, $sidebar)
	{
		$manage_users  = new manage_users;
		$header  = $this->header();
		$c_header= self::content_header(ucfirst($page));

		return $manage_users->view($page,$header,$sidebar, $c_header);
	}

	/**
	 * CHECK PAGE URI
	 * @return data
	 * --------------------------------------------
	 */
	public function view($page = 'dashboard')
	{
		self::checkIfPageExist($page);
		$common = new common;
		$sidebar = new sidebar;

		if( ! $common->check_login() ) redirect('home', 'refresh');

		$common->loadLanguage();
		$common->display_header($page);
		$sidebar = $sidebar->view_sidebar();

		switch ($page) {
			case 'announcements'     : $this->announcements($page, $sidebar);		break;
			case 'dashboard'         : $this->dashboard($page, $sidebar);			break;
			case 'events'            : $this->events($page, $sidebar);				break;
			case 'manage_beneficiary': $this->manage_beneficiary($page, $sidebar);	break;
			case 'manage_users'      : $this->manage_users($page, $sidebar);		break;
			default: $this->dashboard($page, $sidebar); 							break;
		}

		$common->display_footer();
	}
}
?>