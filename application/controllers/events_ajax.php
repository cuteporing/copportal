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

class events_ajax extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('beneficiary_model');
		$this->load->model('events_model');
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
	 * CHECKS IF EVENT DATE IS CORRECT
	 * ARRAY OF ERROR MSG
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_event_date()
	{
		$error_log  = array();
		$date = trim(preg_replace('/\s+/',' ', $this->input->post('event_date')));
		$date = explode('-', $date);

		$date_start = common::format_date($date[0]);
		$date_end   = common::format_date($date[1]);

		if( $date_start > $date_end ){
			array_push($error_log, array(
				'input'=>'event_date',
				'error_msg'=>'End date should be later than starting date ')
			);
		}
		return $error_log;
	}

	/**
	 * CHECKS IF EVENT DOES EXIST
	 * ARRAY OF ERROR MSG
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_event_exist()
	{
		$error_log= array();
		$event_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$result   = $this->events_model->get_events('event_id', $event_id);

		if( !$result ){
			$error_log = array(
				'status'=>'beneficiary',
				'msg'=>'Sorry this event does not exist anymore'
			);
		}
		return $error_log;
	}

	/**
	 * CHECKS IF BENEFICIARY ALREADY JOINED THE EVENT
	 * ARRAY OF ERROR MSG
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_member_exist()
	{
		$event_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$beneficiary_id = $this->input->post('beneficiary_id');
		$result = $this->events_model->check_member($event_id, $beneficiary_id);

		$error_log= array();
		if( $result > 0 ){
			$error_log = array(
				'status'=>'error',
				'msg'=>'Beneficiary already joined'
			);
		}
		return $error_log;
	}

	/**
	 * VALIDATES ALL POST DATA NEEDED FOR CREATING AN EVENT
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_event_create()
	{
		$error_log = array();
		$required_field = array(
			'category',
			'event_date',
			'location',
			'time_end',
			'time_start',
			'title');

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			return common::response_msg(200, 'error_field', '', $error_log);
		//IF EVENT DATE IS NOT CORRECT
		}elseif( count($this->validate_event_date()) > 0 ){
			$error_log = $this->validate_event_date();
			return common::response_msg(200, $error_log['status'], $error_log['msg']);
		//IF THERE ARE NO ERROR
		}else{
			return FALSE;
		}
	}

	/**
	 * VALIDATES ALL POST DATA NEEDED FOR CREATING AN EVENT
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_event_member()
	{
		$error_log = array();
		$required_field = array(
			'beneficiary_id');

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			$error_log[0]['error_msg'] = 'Cannot find beneficiary';
			return common::response_msg(200, 'error_field', '', $error_log);

		//IF EVENT DOES NOT EXIST
		}elseif( count($this->validate_event_exist()) > 0 ){
			$error_log = $this->validate_event_exist();
			return common::response_msg(200, 'error', $error_log['msg']);

		//IF MEMBER ALREADY JOINED
		}elseif( count($this->validate_member_exist()) > 0 ){
			$error_log = $this->validate_member_exist();
			return common::response_msg(200, 'warning', $error_log['msg']);

		//IF EVENT DATE IS NOT CORRECT
		}else{
			return FALSE;
		}
	}

	/**
	 * ADD BENEFICIARY TO THE LIST OF MEMBER JOINING IN AN
	 * EVENT
	 * @return JSON, $response
	 * --------------------------------------------------------
	 */
	public function member_add()
	{
		if( $this->validate_event_member() ){
			echo $this->validate_event_member();
			exit;
		}

		$event_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$beneficiary_id = $this->input->post('beneficiary_id');

		$data = array(
			'event_id'=>$event_id,
			'id'      =>$beneficiary_id
			);

		$result = $this->events_model->add_event_member($data);

		if( $result['status'] == 'error' ){
			echo common::response_msg(200, $result['status'], $result['msg']);
		}else{
			echo common::response_msg(200, 'refresh', '');
		}
	}

	/**
	 * ADD BENEFICIARY TO THE LIST OF MEMBER JOINING IN AN
	 * EVENT
	 * @return JSON, $response
	 * --------------------------------------------------------
	 */
	public function member_delete()
	{
		$event_id      = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$beneficiary_id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		$result = $this->events_model->delete_event_member($event_id, $beneficiary_id);

		if( $result ){
			echo common::response_msg(200, 'success', 'Beneficiary has been removed');
		}else{
			echo common::response_msg(200, 'error', 'Cannot remove beneficiary from the event');
		}
	}

	/**
	 * CREATES AN EVENT
	 * @return JSON, $response
	 * --------------------------------------------------------
	 */
	public function member_list()
	{
		$data  = array();
		$keyword = ucfirst($this->input->get('keyword'));
		$event_id= str_replace('/', '', $this->uri->slash_segment(3, 'leading'));

		$result  = $this->beneficiary_model->get_beneficiary_list($keyword);
		foreach ($result as $row) {
			array_push($data, array(
				'label'=>$row->first_name.' '.$row->last_name,
				'value'=>$row->id,
				));
		}
		echo json_encode($data);
	}

	/**
	 * CREATES AN EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function create()
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
			'owner_id'        =>$session_data['id'],
			'title'           =>$this->input->post('title'),
			'status'          =>'open',
			'category_id'     =>$this->input->post('category'),
			'date_entered'    =>common::get_today(),
			'date_start'      =>$date_start,
			'date_end'        =>$date_end,
			'time_start'      =>$time_start,
			'time_end'        =>$time_end,
			'location'        =>ucfirst($this->input->post('location')),
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
		$result = $this->events_model->create_events($event_data, $description_data);

		echo common::response_msg(200, $result['status'], $result['msg']);
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
	 * CLOSE THE EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function close()
	{
		$event_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$data = array(
			'event_id'=> $event_id,
			'status'  => 'close'
			);

		$result = $this->events_model->close_events($data);
		if( $result ){
			echo common::response_msg(200, 'refresh', '');
		}else{
			echo common::response_msg(200, 'error', 'Error while closing the event');
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
			'location'        =>ucfirst($this->input->post('location')),
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