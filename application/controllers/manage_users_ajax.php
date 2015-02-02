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

include_once('common.php');
include_once('users.php');

class manage_users_ajax extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('users_model');
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

	/**
	 * CHECKS IF THE PASSWORD AND THE CONFIRMATION PASSWORD IS
	 * THE SAME
	 * ARRAY OF ERROR MSG
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_password()
	{
		$error_log  = array();

		if( $this->input->post('user_password') !== $this->input->post('re_user_password') ){
			array_push($error_log, array(
				'input'=>'user_password',
				'error_msg'=>'Password does not match ')
			);
		}
		return $error_log;
	}

	/**
	 * VALIDATES ALL POST DATA NEEDED FOR CREATING AN EVENT
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_users_create()
	{
		$error_log = array();
		$required_field = array(
			'user_name', 'first_name', 'last_name',
			'gender', 'user_password');

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			return common::response_msg(200, 'error_field', '', $error_log);
		}elseif( count($this->validate_password()) > 0 ){
			$error_log = $this->validate_password();
			return common::response_msg(200, 'error_field', '', $error_log);
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
		if( $this->validate_users_create() ){
			echo $this->validate_users_create();
			exit;
		}
		$users = new users;
		$phone_list = array();

		$session_data = $this->session->userdata('logged_in');

		//GET ALL THE PHONE NUMBER AND TEMPORARILY SAVE IT
		//IN AN ARRAY
		foreach ($this->input->post('phone') as $phone) {
			if( $phone !== '' ){
				array_push($phone_list, $phone);
			}
		}

		//SAVE THE PHONE NUMBER IN JSON FORMAT
		$phone_json = json_encode($phone_list);

		//GET PHP VERSION TO DETERMINE WHAT KIND OF ENCRYPTION
		//TO BE USED
		$users->checkPHPVersion();

		$user_info = array(
			'user_name' =>$this->input->post('username'),
			'crypt_type'=>''
			);

		//GET THE ENCRYPTED PASSWORD W/ SALT
		$encrypt_pass = $users->encrypt_password(
			$user_info, $this->input->post('password'));

		echo common::response_msg(200, 'error', 'aa', $encrypt_pass);
		exit;

		$announcement_data = array(
			'user_name'         =>$this->input->post('user_name'),
			'user_password'     =>$this->input->post('user_password'),
			'first_name'        =>$this->input->post('first_name'),
			'last_name'         =>$this->input->post('last_name'),
			'gender'            =>$this->input->post('gender'),
			'is_admin'          =>'on',
			'date_entered'      =>common::get_today(),
			'date_modified'     =>common::get_today(),
			'phone'             =>$phone_json,
			'email'             =>$this->input->post('email'),
			'status'            =>$this->input->post('status'),
			'address_street'    =>$this->input->post('address_street'),
			'address_postalcode'=>'',
			'deleted'           =>0,
			'crypt_type'        =>$users->checkPHPVersion()
			);

		$description_data = array();
		$description = str_split($this->input->post('description'), 1000);
		$sequence = 1;

		foreach ($description as $text) {
			array_push($description_data, array(
				'announcement_id' => 0,
				'description'     => $text,
				'sequence'        => $sequence)
			);
			$sequence++;
		}
		$result = $this->announcements_model->create_announcements($announcement_data, $description_data);

		echo common::response_msg(200, $result['status'], $result['msg']);
	}

}
?>