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

class events extends account
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('events_model');
		$this->load->helper('file');
	}

	public function create()
	{
		$data['events_category'] = $this->events_model->get_categories();

		return $this->load->view('templates/forms/event_form', $data);
	}

	public function edit()
	{
		$session_data = $this->session->userdata('logged_in');

		$event_id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		//IF THERE IS NO EVENT ID FROM URI, SHOW ERROR RECORD NOT FOUND
		if( $event_id == '' ){
			return $this->load->view('error/record_not_found');
		}

		//GET EVENT DETAILS
		$result = $this->events_model->get_events('event_id', $event_id);
		//GET EVENT DESCRIPTION
		$result_desc = $this->events_model->get_event_desc($event_id);

		//IF THERE IS NO EVENT, SHOW ERROR RECORD NOT FOUND
		if( $result === FALSE ){
			return $this->load->view('error/record_not_found');
		}

		$result[0]->date_start =  common::format_date($result[0]->date_start, 'm/d/Y');
		$result[0]->date_end   =  common::format_date($result[0]->date_end, 'm/d/Y');

		$data['events_category'] = $this->events_model->get_categories();
		$data['result']          = $result[0];
		$data['result_desc']     = ($result_desc)? $result_desc : array();

		return $this->load->view('templates/forms/event_form', $data);
	}

	public function get_events()
	{
		$result = $this->events_model->get_events();

		for( $i=0; $i<count($result); $i++ ){
			$date_start= $result[$i]['date_start'];
			$date_end  = $result[$i]['date_end'];
			$date = $date_start.' - '.$date_end;

			$date_start = explode('-', $date_start);
			$date_end = explode('-', $date_end);

			// if( $date_start == $date_end ){
			// 	$date = common::format_date($date_start, 'M d, Y');
			// }else{
				// $date = $date_start.' - '.$date_end;
			// }
			// elseif( $date_start[0] == $date_end[0] &&
			// 		 $date_start[1] == $date_start[1] ){
			// 	$date = common::format_date($date_start, 'M ');
			// 	for($i=$date_start[2]; $i <= $date_end[2]; $i++){
			// 		$date.= $i;
			// 		if( $i < $date_end[2] ){
			// 			$date.=', ';
			// 		}
			// 	}
			// 	$date.= $date_start[0];
			// }
			// else{
			// 	$date = common::format_date($date_start, 'm-d-Y').' - ';
			// 	$date.= common::format_date($date_end, 'm-d-Y');
			// }
			$result[$i]['date'] =  $date;
		}
		$data['btn_edit']     = 'account/events/edit/';
		$data['btn_delete']   = 'events_ajax/delete/';
		$data['table_name']   = 'Trainings and seminars';
		$data['fieldname']    = array('title','date', 'location', 'action');
		$data['field_label']  = array('Activity','Date', 'Venue', '&nbsp;');
		$data['result']       = $result;

		return $this->load->view('templates/tables/data_tables_full', $data);
	}

	/**
	 * DISPLAY EVENTS PAGE
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
			default:$this->get_events();     break;
		}
		//CONTENT FOOTER
		$this->load->view('templates/accounts/footer');
	}
}
?>