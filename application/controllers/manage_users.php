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

class manage_users extends account
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('city_model');
		$this->load->model('events_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	/**
	 * GENDER COMBO BOX
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_gender()
	{
		return array('Female', 'Male', 'Other');
	}

	/**
	 * DISPLAY CREATE USER PAGE
	 * @return table
	 * --------------------------------------------
	 */
	public function create()
	{
		$data['city_list'] = $this->city_model->get_cities();
		$data['gender_list'] = $this->get_gender();
		
		$this->load->view('templates/forms/user_form', $data);
	}

	/**
	 * DISPLAY MANAGE USERS PAGE
	 * @param String, $page
	 * @param String, $header
	 * @param String, $sidebar
	 * @param String, $c_header
	 * @return page
	 * --------------------------------------------
	 */
	public function view($page, $header, $sidebar, $c_header)
	{
		$session_data = $this->session->userdata('logged_in');
		$data['header']  = $header;
		$data['sidebar'] = $sidebar;
		$data['content_header'] = $c_header;

		$parameter = $this->uri->slash_segment(3, 'leading');

		//CONTENT HEADER
		$this->load->view('templates/accounts/header', $data);

		switch ($parameter) {
			case '/create': $this->create(); break;
			case '/edit'  : $this->edit();   break;
			default:$this->get_users();     break;
		}
		//CONTENT FOOTER
		$this->load->view('templates/accounts/footer');
	}
}
?>