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
		$this->load->model('users_model');
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
	 * EDIT USER
	 * @return PAGE
	 * --------------------------------------------
	 */
	public function edit()
	{
		$id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		//IF THERE IS NO BENEFICIARY ID FROM URI, SHOW ERROR RECORD NOT FOUND
		if( $id == '' ){
			return $this->load->view('error/record_not_found');
		}

		//GET BENEFICIARY DETAILS
		$result = $this->users_model->get_user('id', $id);

		//IF THERE IS NO BENEFICIARY, SHOW ERROR RECORD NOT FOUND
		if( $result === FALSE ){
			return $this->load->view('error/record_not_found');
		}

		$selected = array(
			'address_city_id'=>$result[0]->address_city_id,
			'gender' =>$result[0]->gender
			);
		$phone_list = json_decode( $result[0]->phone );

		if( !count( $phone_list ) > 0 ){
			$data['phone_list'] = '';
		}else{
			$data['phone_list'] = $phone_list;
		}

		$data['result']      = $result[0];
		$data['selected']    = $selected;
		$data['city_list']   = $this->city_model->get_cities();
		$data['gender_list'] = $this->get_gender();

		return $this->load->view('templates/forms/beneficiary_form', $data);
	}

	/**
	 * DISPLAY THE LIST OF USERS
	 * @return table
	 * --------------------------------------------
	 */
	public function get_users()
	{
		$result = $this->users_model->get_user();

		for( $i=0; $i<count($result); $i++ ){
			$result[$i]['name'] =  '<b>'.$result[$i]['last_name'].'</b>, '.$result[$i]['first_name'];
			$result[$i]['result_id'] = $result[$i]['id'];
		}

		$data['btn_edit']     = 'account/manage_users/edit/';
		$data['btn_delete']   = 'manage_users_ajax/delete/';
		$data['table_name']   = 'List of users';
		$data['fieldname']    = array('name', 'action');
		$data['field_label']  = array('Name', '&nbsp;');
		$data['result']       = $result;

		return $this->load->view('templates/tables/data_tables_full', $data);
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