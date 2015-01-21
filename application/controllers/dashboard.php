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

class dashboard extends account
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('events_model');
		$this->load->model('beneficiary_model');
	}

	/**
	 * GET ATTRIBUTE OF STATUS BOX
	 * @param String, $box
	 * @param Integer, $data
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_stat_attribute($box,$data)
	{
		switch ($box) {
			case 'ongoing_events' :
						$color       = 'aqua';
						$description = 'Ongoing Events';
						$icon        = 'android_calendar';
						$link        = 'account/events/latest';
						break;
			case 'beneficiary':
						$color       = 'green';
						$description = 'Beneficiaries';
						$icon        = 'person_add';
						$link        = 'account/beneficiary/';
						break;
			case 'members':
						$color       = 'red';
						$description = 'Members';
						$icon        = 'people';
						$link        = 'account/manage_users';
						break;
			default:
						$color       = 'aqua';
						$description = '';
						$icon        = '';
						$link        = '';
						break;
		}

		return array(
							'color'=>$color,
							'data'=>$data,
							'description'=>$description,
							'icon'=>$icon,
							'link'=>$link
							);
	}

	/**
	 * DISPLAY STATUS BOX
	 * @return String, $stat_box
	 * --------------------------------------------
	 */
	public function display_admin_stat_box()
	{
		$details    = array();
		$users      = new users;
		$status_box = new status_box;

		//GET DESCRIPTION FOR STATUS BOX ATTRIBUTE
		$no_of_ongoing     = $this->events_model->get_no_of_events('ongoing');
		$no_of_beneficiary = $this->beneficiary_model->count_beneficiaries();
		$no_of_members     = $users->get_no_of_user();

		//STATUS BOX ATTRIBUTES
		$ongoing_detail     = $this->get_stat_attribute('ongoing_events', $no_of_ongoing);
		$beneficiary_detail = $this->get_stat_attribute('beneficiary', $no_of_beneficiary);
		$members_detail     = $this->get_stat_attribute('members', $no_of_members);

		//GET ALL DETAILS IN AN ARRAY
		array_push($details, $ongoing_detail);
		array_push($details, $beneficiary_detail);
		array_push($details, $members_detail);

		//CREATE A STATUS BOX
		$stat_box = $status_box->view($details);

		return $stat_box;
	}

	public function display_user_stat_box()
	{
		$stat_box = '';
		return $stat_box;
	}

	/**
	 * DISPLAY DASHBOARD PAGE
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

		if( $session_data['is_admin'] == 'on' ){
			$status_box = $this->display_admin_stat_box();
		}else{
			$status_box = $this->display_user_stat_box();
		}

		$data['header']  = $header;
		$data['sidebar'] = $sidebar;
		$data['content_header'] = $c_header;
		$data['stat_box'] = $status_box;
		
		$this->load->view('templates/accounts/header', $data);
		$this->load->view('account/'.$page, $data);
		$this->load->view('templates/accounts/footer');
	}
}
?>