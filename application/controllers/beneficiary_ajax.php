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

class beneficiary_ajax extends CI_controller
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

		return $result;
	}

	// /**
	//  * CHECKS IF EVENT DATE IS CORRECT
	//  * ARRAY OF ERROR MSG
	//  * @return Array, $error_log
	//  * --------------------------------------------------------
	//  */
	// public function validate_event_date()
	// {
	// 	$error_log  = array();
	// 	$date = trim(preg_replace('/\s+/',' ', $this->input->post('event_date')));
	// 	$date = explode('-', $date);

	// 	$date_start = common::format_date($date[0]);
	// 	$date_end   = common::format_date($date[1]);

	// 	if( $date_start > $date_end ){
	// 		array_push($error_log, array(
	// 			'input'=>'event_date',
	// 			'error_msg'=>'End date should be later than starting date ')
	// 		);
	// 	}
	// 	return $error_log;
	// }

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
			'street_address');

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			return common::response_msg(200, 'error_field', '', $error_log);
		}elseif( $this->check_beneficiary() ){
			return common::response_msg(200, 'error_confirm', 'There is already a beneficiary w/ the same name, Arey you sure you want to continue?');
		}
		// //IF EVENT DATE IS NOT CORRECT
		// }elseif( count($this->validate_event_date()) > 0 ){
		// 	$error_log = $this->validate_event_date();
		// 	return common::response_msg(200, 'error_field', '', $error_log);
		// //IF THERE ARE NO ERROR
		// }else{
		// 	return FALSE;
		// }
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
		// $session_data = $this->session->userdata('logged_in');

		// $date = trim(preg_replace('/\s+/',' ', $this->input->post('event_date')));
		// $date = explode('-', $date);

		// $date_start = common::format_date($date[0]);
		// $date_end   = common::format_date($date[1]);
		// $time_start = common::format_time($this->input->post('time_start'));
		// $time_end   = common::format_time($this->input->post('time_end'));

		// $event_data = array(
		// 	'owner_id'        =>$session_data['id'],
		// 	'title'           =>$this->input->post('title'),
		// 	'status'          =>'open',
		// 	'category_id'     =>$this->input->post('category'),
		// 	'date_entered'    =>common::get_today(),
		// 	'date_start'      =>$date_start,
		// 	'date_end'        =>$date_end,
		// 	'time_start'      =>$time_start,
		// 	'time_end'        =>$time_end,
		// 	'location'        =>$this->input->post('location'),
		// 	'slug'            =>url_title($this->input->post('title'), 'dash', TRUE)
		// 	);

		// $description_data = array();
		// $description = str_split($this->input->post('description'), 1000);
		// $sequence = 1;

		// foreach ($description as $text) {
		// 	array_push($description_data, array(
		// 		'event_id'   => 0,
		// 		'description'=> $text,
		// 		'sequence'   => $sequence)
		// 	);
		// 	$sequence++;
		// }
		// $result = $this->events_model->create_events($event_data, $description_data);

		// echo common::response_msg(200, $result['status'], $result['msg']);
	}

	/**
	 * DELETES AN EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function delete()
	{
		$event_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$result = $this->events_model->delete_event($event_id);
		if( $result ){
			echo common::response_msg(200, 'success', 'Event has been deleted');
		}else{
			echo common::response_msg(200, 'error', 'Cannot delete event');
		}
	}

	/**
	 * CREATES AN EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function edit()
	{
		if( $this->validate_event_create() ){
			echo $this->validate_event_create();
			exit;
		}
		$session_data = $this->session->userdata('logged_in');

		$date = trim(preg_replace('/\s+/',' ', $this->input->post('event_date')));
		$date = explode('-', $date);

		$date_start = common::format_date($date[0]);
		$date_end   = common::format_date($date[1]);
		$time_start = common::format_time($this->input->post('time_start'));
		$time_end   = common::format_time($this->input->post('time_end'));

		$event_data = array(
			'event_id'        =>$this->input->post('event_id'),
			'owner_id'        =>$session_data['id'],
			'title'           =>$this->input->post('title'),
			'status'          =>'open',
			'category_id'     =>$this->input->post('category'),
			'date_entered'    =>common::get_today(),
			'date_start'      =>$date_start,
			'date_end'        =>$date_end,
			'time_start'      =>$time_start,
			'time_end'        =>$time_end,
			'location'        =>$this->input->post('location'),
			'slug'            =>url_title($this->input->post('title'), 'dash', TRUE)
			);

		$description_data = array();
		$description = str_split($this->input->post('description'), 1000);
		$sequence = 1;

		foreach ($description as $text) {
			array_push($description_data, array(
				'event_id'   => 0,
				'description'=> $text,
				'sequence'   => $sequence)
			);
			$sequence++;
		}
		$result = $this->events_model->update_events($event_data, $description_data);

		echo common::response_msg(200, $result['status'], $result['msg']);
	}
}
?>