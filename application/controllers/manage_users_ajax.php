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
	 * VALIDATES ALL POST DATA NEEDED FOR CREATING AN EVENT
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_announcement_create()
	{
		$error_log = array();
		$required_field = array('first_name', 'last_name', 'gender', );

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
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
		if( $this->validate_announcement_create() ){
			echo $this->validate_announcement_create();
			exit;
		}
		$session_data = $this->session->userdata('logged_in');

		$announcement_data = array(
			'owner_id'     =>$session_data['id'],
			'title'        =>$this->input->post('title'),
			'date_entered' =>common::get_today(),
			'slug'         =>url_title($this->input->post('title'), 'dash', TRUE)
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

	/**
	 * CREATES AN EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function edit()
	{
		if( $this->validate_announcement_create() ){
			echo $this->validate_announcement_create();
			exit;
		}
		$session_data = $this->session->userdata('logged_in');
		$announcement_id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		$announcement_data = array(
			'owner_id'       =>$session_data['id'],
			'announcement_id'=>$this->input->post('announcement_id'),
			'title'          =>$this->input->post('title'),
			'slug'           =>url_title($this->input->post('title'), 'dash', TRUE)
			);

		$description_data = array();
		$description = str_split($this->input->post('description'), 1000);
		$sequence = 1;

		foreach ($description as $text) {
			array_push($description_data, array(
				'announcement_id' => $announcement_id,
				'description'     => $text,
				'sequence'        => $sequence)
			);
			$sequence++;
		}
		$result = $this->announcements_model->update_announcements($announcement_data, $description_data);

		echo common::response_msg(200, $result['status'], $result['msg']);
	}

	/**
	 * DELETES AN ANNOUNCEMENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function delete()
	{
		$announcement_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));

		$result = $this->announcements_model->delete_announcement($announcement_id);
		if( $result ){
			echo common::response_msg(200, 'success', 'Announcement has been deleted');
		}else{
			echo common::response_msg(200, 'error', 'Cannot delete announcement');
		}
	}
}
?>