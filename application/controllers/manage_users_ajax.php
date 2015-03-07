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

class manage_users_ajax extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
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
	 * CHECKS IF THE USERNAME ALREADY EXIST
	 * ARRAY OF ERROR MSG
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_username()
	{
		$error_log  = array();
		$users = new users;
		$mode = str_replace('/', '', $this->uri->slash_segment(2, 'leading'));

		if( $this->users_model->check_user($this->input->post('user_name')) !== FALSE &&
			$mode == 'create' ){
			array_push($error_log, array(
				'input'=>'user_name',
				'error_msg'=>'There is already an existing username ')
			);
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
	 * VALIDATES ALL POST DATA NEEDED FOR CREATING A USER
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_users_create()
	{
		$error_log      = array();

		$required_field = array(
			'user_name', 'first_name', 'last_name',
			'gender', 'user_password');

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			return common::response_msg(200, 'error_field', '', $error_log);
		//CHECK IF USERNAME ALREADY EXIST
		}elseif( count($this->validate_username()) > 0 ){
			$error_log = $this->validate_username();
			return common::response_msg(200, 'error_field', '', $error_log);
		//CHECK IF PASSWORD AND CONFIRM PASSWORD IS THE SAME
		}elseif( count($this->validate_password()) > 0 ){
			$error_log = $this->validate_password();
			return common::response_msg(200, 'error_field', '', $error_log);

		}else{
			return FALSE;
		}
	}

	/**
	 * VALIDATES ALL POST DATA NEEDED FOR CHANGING USER'S
	 * PASSWORD
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_change_pass()
	{
		$error_log = array();
		$required_field = array('user_password');
		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			return common::response_msg(200, 'error_field', '', $error_log);
		}else{
			return FALSE;
		}
	}

	/**
	 * CREATES A USER
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
		$version = $users->checkPHPVersion();

		$user_info = array(
			'user_name' =>$this->input->post('user_name'),
			'crypt_type'=>''
			);

		//GET THE ENCRYPTED PASSWORD W/ SALT
		$encrypt_pass = $users->encrypt_password(
			$user_info, $this->input->post('user_password'));

		$data = array(
			'user_name'         =>$this->input->post('user_name'),
			'user_password'     =>$encrypt_pass,
			'first_name'        =>ucfirst($this->input->post('first_name')),
			'last_name'         =>ucfirst($this->input->post('last_name')),
			'gender'            =>strtolower( $this->input->post('gender') ),
			'user_kbn'          =>$this->input->post('user_kbn'),
			'dept_id'           =>$this->input->post('dept_id'),
			'date_modified'     =>common::get_today(),
			'phone'             =>$phone_json,
			'email'             =>$this->input->post('email'),
			'status'            =>$this->input->post('status'),
			'address_street'    =>$this->input->post('address_street'),
			'address_city_id'    =>$this->input->post('city'),
			'deleted'           =>0,
			'crypt_type'        =>$users->checkPHPVersion()
			);

		$result = $this->users_model->create_user($data);

		echo common::response_msg(200, $result['status'], $result['msg']);
	}

	/**
	 * EDIT USER INFO
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function edit()
	{
		$session_data = $this->session->userdata('logged_in');
		$id = $this->input->post('id');

		if( $session_data['user_kbn'] == 30 ){
			if( $this->validate_users_create() ){
				echo $this->validate_users_create();
				exit;
			}
		}

		$users = new users;
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

		if( $session_data['user_kbn'] != 30 ){
				$data = array(
				'id'                =>$id,
				'gender'            =>ucfirst( $this->input->post('gender') ),
				'dept_id'           =>$this->input->post('dept_id'),
				'date_modified'     =>common::get_today(),
				'phone'             =>$phone_json,
				'email'             =>$this->input->post('email'),
				'status'            =>$this->input->post('status'),
				'address_street'    =>$this->input->post('address_street'),
				'address_city_id'   =>$this->input->post('city'),
				'crypt_type'        =>$users->checkPHPVersion()
				);
		}else{
				$data = array(
				'id'                =>$id,
				'first_name'        =>ucfirst($this->input->post('first_name')),
				'last_name'         =>ucfirst($this->input->post('last_name')),
				'gender'            =>ucfirst( $this->input->post('gender') ),
				'user_kbn'          =>$this->input->post('user_kbn'),
				'dept_id'           =>$this->input->post('dept_id'),
				'date_modified'     =>common::get_today(),
				'phone'             =>$phone_json,
				'email'             =>$this->input->post('email'),
				'status'            =>$this->input->post('status'),
				'address_street'    =>$this->input->post('address_street'),
				'address_city_id'   =>$this->input->post('city'),
				'crypt_type'        =>$users->checkPHPVersion()
				);
		}

		$result = $this->users_model->update_user($data);

		echo common::response_msg(200, $result['status'], $result['msg']);
	}

	/**
	 * DELETES A USER
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function delete()
	{
		$id   = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$data = array(
			'id'      => $id,
			'status'  => 'Inactive',
			'deleted' => 1,
			);

		$result = $this->users_model->delete_user($data);
		if( $result ){
			echo common::response_msg(200, 'success', 'User has been deleted');
		}else{
			echo common::response_msg(200, 'error', 'Cannot delete user');
		}
	}

	/**
	 * CHANGE USER'S PASSWORD
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function change_password()
	{
		if( $this->validate_change_pass() ){
			echo $this->validate_change_pass();
			exit;
		}
		$users = new users;

		// GET PHP VERSION TO DETERMINE WHAT KIND OF ENCRYPTION
		// TO BE USED
		$version = $users->checkPHPVersion();

		$user_info = array(
			'user_name' =>$this->input->post('user_name'),
			'crypt_type'=>''
			);

		//GET THE ENCRYPTED PASSWORD W/ SALT
		$encrypt_pass = $users->encrypt_password(
			$user_info, $this->input->post('user_password'));

		$data = array(
			'id'                =>$this->input->post('id'),
			'first_name'        =>$this->input->post('first_name'),
			'user_name'         =>$this->input->post('user_name'),
			'user_password'     =>$encrypt_pass,
			);
		$result = $this->users_model->update_user($data);

		if( $result ){
			echo common::response_msg(200, 'redirect', base_url().'account/manage_users/edit/'.$this->input->post('id'));
		}else{
			echo common::response_msg(200, 'error', 'Cannot change password');
		}
	}
}
?>