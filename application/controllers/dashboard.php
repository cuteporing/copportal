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

class dashboard extends account
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('announcements_model');
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
			case 'my_events' :
						$color       = 'aqua';
						$description = 'My Events';
						$icon        = 'android_calendar';
						$link        = 'account/events/';
						break;
			case 'beneficiary':
						$color       = 'green';
						$description = 'Beneficiaries';
						$icon        = 'person_add';
						$link        = 'account/manage_beneficiary/view';
						break;
			case 'members':
						$color       = 'red';
						$description = 'Members';
						$icon        = 'people';
						$link        = 'account/manage_users';
						break;
			case 'announcements':
						$color       = 'purple';
						$description = 'Announcements';
						$icon        = 'information';
						$link        = 'account/announcements';
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
	public function display_30_stat_box()
	{
		$details    = array();
		$users      = new users;
		$status_box = new status_box;

		$session_data = $this->session->userdata('logged_in');

		$search_events = array();
		$param_events  = array();

		array_push($param_events, array(
			'fieldname'=>'status',
			'data'     =>'Approved'
			));

		$search_events['search_by'] = $param_events;

		//GET DESCRIPTION FOR STATUS BOX ATTRIBUTE
		$no_of_ongoing      = $this->events_model->get_no_of_events($search_events);
		$no_of_beneficiary  = $this->beneficiary_model->count_beneficiaries();
		$no_of_members      = $users->get_no_of_user();
		$no_of_announcements= $this->announcements_model->get_no_anouncements();

		//STATUS BOX ATTRIBUTES
		$ongoing_detail       = $this->get_stat_attribute('ongoing_events', $no_of_ongoing);
		$beneficiary_detail   = $this->get_stat_attribute('beneficiary', $no_of_beneficiary);
		$members_detail       = $this->get_stat_attribute('members', $no_of_members);
		$announcements_detail = $this->get_stat_attribute('announcements', $no_of_announcements);

		//GET ALL DETAILS IN AN ARRAY
		array_push($details, $ongoing_detail);
		array_push($details, $beneficiary_detail);
		array_push($details, $members_detail);
		array_push($details, $announcements_detail);

		//CREATE A STATUS BOX
		$stat_box = $status_box->view($details);

		return $stat_box;
	}

	/**
	 * DISPLAY STATUS BOX
	 * @return String, $stat_box
	 * --------------------------------------------
	 */
	public function display_20_stat_box()
	{
		$details    = array();
		$users      = new users;
		$status_box = new status_box;

		$search_events = array();
		$param_events  = array();

		array_push($param_events, array(
			'fieldname'=>'status',
			'data'     =>'Approved'
			));

		$search_events['search_by'] = $param_events;

		//GET DESCRIPTION FOR STATUS BOX ATTRIBUTE
		$no_of_ongoing      = $this->events_model->get_no_of_events($search_events);
		$no_of_beneficiary  = $this->beneficiary_model->count_beneficiaries();
		$no_of_members      = $users->get_no_of_user();
		$no_of_announcements= $this->announcements_model->get_no_anouncements();

		//STATUS BOX ATTRIBUTES
		$ongoing_detail       = $this->get_stat_attribute('ongoing_events', $no_of_ongoing);
		$beneficiary_detail   = $this->get_stat_attribute('beneficiary', $no_of_beneficiary);
		$members_detail       = $this->get_stat_attribute('members', $no_of_members);
		$announcements_detail = $this->get_stat_attribute('announcements', $no_of_announcements);

		//GET ALL DETAILS IN AN ARRAY
		array_push($details, $ongoing_detail);
		array_push($details, $beneficiary_detail);
		array_push($details, $members_detail);
		array_push($details, $announcements_detail);

		//CREATE A STATUS BOX
		$stat_box = $status_box->view($details);

		return $stat_box;
	}

	public function display_10_stat_box()
	{
		$details    = array();
		$users      = new users;
		$status_box = new status_box;

		$session_data = $this->session->userdata('logged_in');

		$search_events = array();
		$param_events  = array();

		array_push($param_events, array(
			'fieldname'=>'owner_id',
			'data'     =>$session_data['id']
			));

		$search_events['search_by'] = $param_events;

		//GET DESCRIPTION FOR STATUS BOX ATTRIBUTE
		$no_of_ongoing      = $this->events_model->get_no_of_events($search_events);
		$no_of_beneficiary  = $this->beneficiary_model->count_beneficiaries();
		$no_of_members      = $users->get_no_of_user();
		$no_of_announcements= $this->announcements_model->get_no_anouncements();

		//STATUS BOX ATTRIBUTES
		$ongoing_detail       = $this->get_stat_attribute('my_events', $no_of_ongoing);
		$beneficiary_detail   = $this->get_stat_attribute('beneficiary', $no_of_beneficiary);
		$members_detail       = $this->get_stat_attribute('members', $no_of_members);
		$announcements_detail = $this->get_stat_attribute('announcements', $no_of_announcements);

		//GET ALL DETAILS IN AN ARRAY
		array_push($details, $ongoing_detail);
		array_push($details, $beneficiary_detail);
		array_push($details, $members_detail);
		array_push($details, $announcements_detail);

		//CREATE A STATUS BOX
		$stat_box = $status_box->view($details);

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

		if( $session_data['user_kbn'] == 30 ){
			$status_box = $this->display_30_stat_box();
		}else if( $session_data['user_kbn'] == 20 ){
			$status_box = $this->display_20_stat_box();
		}else{
			$status_box = $this->display_10_stat_box();
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