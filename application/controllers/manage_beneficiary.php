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

class manage_beneficiary extends account
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('beneficiary_model');
		$this->load->model('city_model');
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
	 * CREATE BENEFICIARY
	 * @return PAGE
	 * --------------------------------------------
	 */
	public function create()
	{
		$data['city_list'] = $this->city_model->get_cities();
		$data['gender_list'] = $this->get_gender();

		$this->load->view('templates/forms/beneficiary_form', $data);
		$this->load->view('templates/modal', $data);
	}

	/**
	 * EDIT BENEFICIARY
	 * @return PAGE
	 * --------------------------------------------
	 */
	public function edit()
	{
		$beneficiary_id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		//IF THERE IS NO BENEFICIARY ID FROM URI, SHOW ERROR RECORD NOT FOUND
		if( $beneficiary_id == '' ){
			return $this->load->view('error/record_not_found');
		}

		//GET BENEFICIARY DETAILS
		$result = $this->beneficiary_model->get_beneficiary('id', $beneficiary_id);

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
		print_r( $data['phone_list'] );
		$data['result']      = $result[0];
		$data['selected']    = $selected;
		$data['city_list']   = $this->city_model->get_cities();
		$data['gender_list'] = $this->get_gender();

		return $this->load->view('templates/forms/beneficiary_form', $data);
	}

	/**
	 * DISPLAY THE LIST OF BENEFICIARIES
	 * @return table
	 * --------------------------------------------
	 */
	public function get_beneficiaries()
	{
		$result = $this->beneficiary_model->get_beneficiary();

		for( $i=0; $i<count($result); $i++ ){
			$result[$i]['name'] =  '<b>'.$result[$i]['last_name'].'</b>, '.$result[$i]['first_name'];
			$result[$i]['result_id'] = $result[$i]['id'];
		}

		$data['btn_edit']     = 'account/manage_beneficiary/edit/';
		$data['btn_delete']   = 'manage_beneficiary_ajax/delete/';
		$data['table_name']   = 'Trainings and seminars';
		$data['fieldname']    = array('name', 'action');
		$data['field_label']  = array('Name', '&nbsp;');
		$data['result']       = $result;

		return $this->load->view('templates/tables/data_tables_full', $data);
	}

	/**
	 * DISPLAY MANAGE BENEFICIARY PAGE
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
			case '/create': $this->create();    break;
			case '/edit'  : $this->edit();      break;
			default:$this->get_beneficiaries(); break;
		}
		//CONTENT FOOTER
		$this->load->view('templates/accounts/footer');
	}
}
?>