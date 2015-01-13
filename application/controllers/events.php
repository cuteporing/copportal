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
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$session_data = $this->session->userdata('logged_in');
		$data['events_category'] = $this->events_model->get_categories();
		$data['result_msg'] = '';

		//VALIDATE FIELDS
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');

		if( $this->form_validation->run() === FALSE ){
			//SHOW VALIDATION MESSAGES
			$this->load->view('templates/forms/event_form', $data);
		}else{
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
				'max_participants'=>$this->input->post('max_participants'),
				'category_id'     =>$this->input->post('category'),
				'date_entered'    =>common::get_today(),
				'date_start'      =>$date_start,
				'date_end'        =>$date_end,
				'time_start'      =>$time_start,
				'time_end'        =>$time_end,
				'location'        =>$this->input->post('location'),
				'slug'            =>url_title($this->input->post('title'), 'dash', TRUE)
				);

			$description_data = array(
				'event_id'   =>0,
				'description'=>$this->input->post('description'),
				'sequence'   => 1
				);

			//CREATE USER IN DB
			$result = $this->events_model->create_events($event_data, $description_data);
			$data['result_msg'] = $result;

			if( $result['status'] == 'error' ){
					$this->load->view('templates/forms/event_form', $data);
				}else{
					$this->session->set_flashdata('message', $result['msg']);
					return redirect('account/events', 'refresh');
				}
		}
	}

	public function edit()
	{

	}

	public function get_events()
	{
		$result = $this->events_model->get_events();

		for( $i=0; $i<count($result); $i++ ){
			$date_start=$result[$i]['date_start'];
			$date_end  =$result[$i]['date_end'];
			$date      = $date_start." - ".$date_end;
			$result[$i]['date'] =  $date;
		}

		$data['table_name']   = 'Trainings and seminars';
		$data['fieldname']    = array('title','date', 'location', 'max_participants', 'action');
		$data['field_label']  = array('Title','Date', 'Location', 'Max. no', '&nbsp;');
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
			case '/create': $this->create();	break;
			case '/edit'  : $this->edit();		break;
			default:$this->get_events();		break;
		}
		
		//CONTENT FOOTER
		$this->load->view('templates/accounts/footer');
	}
}
?>