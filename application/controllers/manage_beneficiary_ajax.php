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

include_once('common.php');
include_once('users.php');

class manage_beneficiary_ajax extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('beneficiary_model');
	}

	/**
	 * CHECKS IF THE POST DATA IS NOT NULL AND RETURNS AN
	 * ARRAY OF ERROR MSG
	 * @param Array, $input_field
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_required($input_field)
	{
		$error_log  = array();
		foreach ($input_field as $field) {
			if( $this->input->post($field) == '' ){
				$label = str_replace('_', ' ', ucfirst($field));
				array_push($error_log, array(
					'input'=>$field,
					'error_msg'=>$label.' is required')
				);
			}
		}
		return $error_log;
	}

	public function check_beneficiary()
	{
		$name = array(
			'first_name'=>ucfirst( $this->input->post('first_name') ),
			'last_name' =>ucfirst( $this->input->post('last_name') ) );

		$result = $this->beneficiary_model->check_beneficiary($name);
		if( $result === TRUE && $this->input->post('confirm') == 'yes' ){
			$result = FALSE;
		}

		return $result;
	}

	/**
	 * VALIDATES ALL POST DATA NEEDED FOR CREATING AN EVENT
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_beneficiary_create()
	{
		$error_log = array();
		$required_field = array(
			'first_name',
			'last_name',
			'address_street');

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			return common::response_msg(200, 'error_field', '', $error_log);
		}elseif( $this->check_beneficiary() ){
			return common::response_msg(200, 'error_confirm', 'There is already a beneficiary w/ the same name, Are you sure you want to continue?');
		}else{
			return FALSE;
		}
	}

	/**
	 * CREATES AN EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function create()
	{
		if( $this->validate_beneficiary_create() ){
			echo $this->validate_beneficiary_create();
			exit;
		}

		$phone_list = array();

		//GET ALL THE PHONE NUMBER AND TEMPORARILY SAVE IT
		//IN AN ARRAY
		foreach ($this->input->post('phone') as $phone) {
			if( $phone !== '' ){
				array_push($phone_list, $phone);
			}
		}
		//SAVE THE PHONE NUMBER IN JSON FORMAT
		$phone_json = json_encode($phone_list);

		$data = array(
			'first_name'     => ucfirst($this->input->post('first_name')),
			'last_name'      => ucfirst($this->input->post('last_name')),
			'gender'         => $this->input->post('gender'),
			'date_entered'   => common::get_today(),
			'date_modified'  => common::get_today(),
			'phone'          => $phone_json,
			'address_street' => $this->input->post('address_street'),
			'address_city_id'=> $this->input->post('city'),
			'deleted'        => 0
			);

		$result = $this->beneficiary_model->create_beneficiary($data);

		echo common::response_msg(200, $result['status'], $result['msg']);
	}

	/**
	 * DELETES AN EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function delete()
	{
		$id     = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$result = $this->beneficiary_model->delete_beneficiary($id);
		if( $result ){
			echo common::response_msg(200, 'success', 'Beneficiary has been deleted');
		}else{
			echo common::response_msg(200, 'error', 'Cannot delete beneficiary');
		}
	}

	/**
	 * EDIT THE BENEFICIARY PROFILE
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function edit()
	{
		if( $this->validate_beneficiary_create() ){
			echo $this->validate_beneficiary_create();
			exit;
		}

		$phone_list = array();

		//GET ALL THE PHONE NUMBER AND TEMPORARILY SAVE IT
		//IN AN ARRAY
		foreach ($this->input->post('phone') as $phone) {
			if( $phone !== '' ){
				array_push($phone_list, $phone);
			}
		}
		//SAVE THE PHONE NUMBER IN JSON FORMAT
		$phone_json = json_encode($phone_list);

		$data = array(
			'id'             => $this->input->post('id'),
			'first_name'     => ucfirst($this->input->post('first_name')),
			'last_name'      => ucfirst($this->input->post('last_name')),
			'gender'         => $this->input->post('gender'),
			'date_entered'   => common::get_today(),
			'date_modified'  => common::get_today(),
			'phone'          => $phone_json,
			'address_street' => $this->input->post('address_street'),
			'address_city_id'=> $this->input->post('city'),
			'deleted'        => 0
			);

		$result = $this->beneficiary_model->update_beneficiary($data);
		echo common::response_msg(200, $result['status'], $result['msg']);
	}
}
?>