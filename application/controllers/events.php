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

class events extends CI_controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('beneficiary_model');
		$this->load->model('department_model');
		$this->load->model('events_model');
		$this->load->model('users_model');
		$this->load->library('pagination');
	}

	/**
	 * SET OF ACTION BUTTON FOR TABLE DISPLAY
	 * @return Array
	 * --------------------------------------------
	 */
	static function action_btn($type=30)
	{
		if($type == 10){
			return array(
				0 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-toggle',
							'value'=>'tooltip'),
						1 => array(
							'data_name' =>'title',
							'value'=>'View')
						),
					'icon' =>'fa fa-tasks',
					'title'=>'View',
					'type' =>'warning',
					'url'  =>'account/events/manage/',
					)
				);
		}else if( $type == 30 ){
			return array(
				0 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-toggle',
							'value'=>'tooltip'),
						1 => array(
							'data_name' =>'title',
							'value'=>'View')
						),
					'icon' =>'fa fa-tasks',
					'title'=>'View',
					'type' =>'warning',
					'url'  =>'account/events/manage/',
					),
				1 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-ajax',
							'value'=>'delete'),
						1 => array(
							'data_name' =>'data-del-type',
							'value'=>'table'),
						2 => array(
							'data_name' =>'data-toggle',
							'value'=>'tooltip'),
						3 => array(
							'data_name' =>'title',
							'value'=>'Delete')),
					'icon' =>'fa fa-trash-o',
					'title'=>'Delete',
					'type' =>'danger',
					'url'  =>'events_ajax/delete/',
					)
				);
		}
	}

	/**
	 * CREATE AN EVENT ALBUM MODAL
	 * @return modal
	 * --------------------------------------------
	 */
	public function upload_photo_modal()
	{
		$event_id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		$data['event_id']     = $event_id;
		$data['modal_id']     = 'event-upload-modal';
		$data['modal_header'] = '<i class="fa fa-upload"></i> Upload photos';
		$this->load->view('templates/modal/modal_header', $data);
		$this->load->view('templates/forms/event_upload_form', $data);
		$this->load->view('templates/modal/modal_footer', $data);
	}


	/**
	 * DISPLAY CREATE EVENT PAGE
	 * @return table
	 * --------------------------------------------
	 */
	public function create()
	{
		$data['events_category']  = $this->events_model->get_categories();
		$data['beneficiary_list'] = $this->beneficiary_model->get_beneficiary_list();

		// $this->upload_photo_modal();
		$this->load->view('templates/forms/event_form', $data);
	}

	/**
	 * DISPLAY EVENTS EDIT PAGE
	 * @return page
	 * --------------------------------------------
	 */
	public function edit()
	{
		$session_data = $this->session->userdata('logged_in');

		$event_id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));
		$beneficiary_id_list = array();

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

		$selected = array(
			'category_id'=>$result[0]['category_id']
			);

		$result[0]['date_start'] =  common::format_date($result[0]['date_start'], 'm/d/Y');
		$result[0]['date_end']   =  common::format_date($result[0]['date_end'], 'm/d/Y');

		$result_beneficiary = $this->events_model->get_members($event_id);

		foreach ($result_beneficiary as $beneficiary) {
			array_push($beneficiary_id_list, $beneficiary['id']);
		}

		$data['beneficiary_list']   = $this->beneficiary_model->get_beneficiary_list();
		$data['result_beneficiary'] = $beneficiary_id_list;
		$data['events_category']    = $this->events_model->get_categories();
		$data['result']             = $result[0];
		$data['result_desc']        = ($result_desc)? $result_desc : array();
		$data['selected']           = $selected;

		$this->load->view('templates/forms/event_form', $data);
		$this->upload_photo_modal($data);

	}

	/**
	 * MANAGE EVENTS
	 * @return table
	 * --------------------------------------------
	 */
	public function manage()
	{
		$event_id    = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		//IF THERE IS NO EVENT ID FROM URI, SHOW ERROR RECORD NOT FOUND
		if( $event_id == '' ){
			return $this->load->view('error/record_not_found');
		}
		//CHECK USER LEVEL
		$session_data = $this->session->userdata('logged_in');

		//GET EVENT DETAILS
		$result_event = $this->events_model->get_events('cop_events.event_id', $event_id);
		if( $result_event ) {
			$date_start= $result_event[0]['date_start'];
			$date_end  = $result_event[0]['date_end'];

			$date = common::display_date($date_start, $date_end);

			//FORMAT TIME DISPLAY
			( $result_event[0]['time_start'] == $result_event[0]['time_end'] )?
				$time = $result_event[0]['time_start']
			: $time = $result_event[0]['time_start'].' - '.$result_event[0]['time_end'];

			$result_event[0]['date'] = $date;
			$result_event[0]['time'] = $time;

			if( $session_data['user_kbn'] == 10 &&
					$result_event[0]['status'] == 'Revise'){
					$data['show_action_btn'] = 'restrict';
			}else if( $session_data['user_kbn'] <= 30 &&
					$session_data['user_kbn'] != 10){
					$data['show_action_btn'] = 'all';
			}
			//GET EVENT OWNER
			$result_owner       = json_decode(json_encode( $this->users_model->get_user('id', $result_event[0]['owner_id']) ), true);
			//GET KBN
			$result_kbn         = $this->users_model->get_user_kbn('kbn_id', $result_owner[0]['user_kbn']);
			//GET EVENT DESCRIPTION
			$result_desc        = $this->events_model->get_event_desc($event_id);
			//GET EVENT BENEFICIARY
			$result_beneficiary = $this->events_model->get_members($event_id);
			//GET EVENT CONFIRMATION
			$result_confirmation= $this->events_model->get_confirmation($event_id);
			//GET EVENT COMMENTS
			$result_comments    = $this->events_model->get_comments($event_id);
			//GET DEPARTMENT
			$result_deparment   = json_decode(json_encode( $this->department_model->get_department(
				'dept_id', $result_owner[0]['dept_id']) ), true);

			$result_event[0]['department'] = $result_deparment[0]['department'];
			$result_event[0]['role']       = $result_kbn[0]['role'];

			if( $result_desc )         $data['result_desc']         = $result_desc;
			if( $result_owner )        $data['result_owner']        = $result_owner;
			if( $result_beneficiary )  $data['result_beneficiary']  = $result_beneficiary;
			if( $result_confirmation ) $data['result_confirmation'] = $result_confirmation[0];
			if( $result_comments )     $data['result_comments']     = $result_comments;

			$data['result_event'] = $result_event[0];
			$this->load->view('account/events_view', $data);
		}else{
			$this->load->view('account/events_view');
		}
	}

	/**
	 * DISPLAY EVENT LIST PAGE
	 * @return table
	 * --------------------------------------------
	 */
	public function get_events()
	{
		$session_data = $this->session->userdata('logged_in');

		//CHECK LOGGED IN USER LEVEL

		//CAN VIEW ALL EVENTS
		if( $session_data['user_kbn'] == 30 || $session_data['user_kbn'] == 20 ){
			$result = $this->events_model->get_event_list();
			$data['action_btn'] = self::action_btn(30);

		//VIEW ONLY THE USER'S CREATED EVENTS
		}else{
			$params = array();
			$search = array();

			//SEARCH PARAMETERS FOR EVENTS
			array_push($search, array(
					'fieldname'=>'owner_id',
					'data'     => (int) $session_data['id']
					)
			);

			$params['search_by'] = $search;

			//GET EVENTS
			$result = $this->events_model->get_event_list($params);
			$data['action_btn'] = self::action_btn(10);
		}

		//IF AN EVENT IS FOUND
		if( $result ){
			for( $i=0; $i<count($result); $i++ ){
				$date_start= $result[$i]['date_start'];
				$date_end  = $result[$i]['date_end'];

				$date = common::display_date($date_start, $date_end);

				$result[$i]['date']      = $date;
				$result[$i]['result_id'] = $result[$i]['event_id'];
			}

			$data['result']     = $result;
		}

		//DISPLAY LIST IN A TABLE
		$data['table_name']   = 'Trainings and seminars';
		$data['fieldname']    = array('title','date', 'location', 'status', 'action');
		$data['field_label']  = array('Activity','Date', 'Venue', 'Status', '&nbsp;');

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
			case '/manage': $this->manage(); break;
			default:$this->get_events();     break;
		}

		//CONTENT FOOTER
		$this->load->view('templates/accounts/footer');
	}

	/**
	 * DISPLAY ANNOUNCEMENT FRONT-SIDE PAGE
	 * @param String, $page
	 * @return page
	 * --------------------------------------------
	 */
	public function view_artcore($page)
	{
		$limit       = 10;
		$filter      = array();
		$filter_dept = array();
		$params      = array();
		$search      = array();
		$common      = new common;

		$offset     = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));
		$view_type  = str_replace('/', '', $this->uri->slash_segment(2, 'leading'));

		switch ($view_type) {
			case 'archive': $slug = str_replace('/', '', $this->uri->slash_segment(3, 'leading')); break;
			case 'new'    : $slug = str_replace('/', '', $this->uri->slash_segment(3, 'leading')); break;
			case 'title'  : $slug = str_replace('/', '', $this->uri->slash_segment(3, 'leading')); break;
			default: return $common->show_404(); break;
		}
		//SINGLE EVENT DISPLAY
		if( $view_type == 'title' ){
			$slug = str_replace('%20', '-', $slug);

			//GET EVENTS
			$result = $this->events_model->get_events('slug', $slug);

			if( $result ){
				//FORMAT TIME DISPLAY
				( $result[0]['time_start'] == $result[0]['time_end'] )?
					$time = $result[0]['time_start']
				: $time = $result[0]['time_start'].' - '.$result[0]['time_end'];

				$result[0]['time'] = $time;

				//GET EVENT DESCRIPTION
				$result[0]['description'] = $this->events_model->get_event_desc(
							$result[0]['event_id']);
				//FORMAT DISPLAY DATE
				$result[0]['date_display'] = common::display_date(
							$result[0]['date_start'], $result[0]['date_end']);
				//GET EVENT MEMBERS
				$result[0]['members'] = $this->events_model->get_members(
							$result[0]['event_id']);

				//GET EVENT OWNER
				$result_owner       = json_decode(json_encode( $this->users_model->get_user('id', $result[0]['owner_id']) ), true);
				//GET DEPARTMENT
				$result_deparment   = json_decode(json_encode( $this->department_model->get_department(
					'dept_id', $result_owner[0]['dept_id']) ), true);

				$result[0]['department'] = $result_deparment[0]['department'];

				$data['event_single']  = $result[0];
			}else{
				$common->show_404();
			}
		//EVENT LIST
		}else{
			( $offset == '' )? $offset = 0 : $offset = $offset;

			//DISPLAY LIST OF NEW EVENTS
			if( $view_type == 'new' ){

				//GET TOTAL NO. OF NEW EVENTS
				$total_rows = $this->events_model->get_no_of_new_events(
					common::format_date(common::get_today(), 'Y-m-d'));

				array_push($search, array(
					'fieldname'=>'status',
					'data'     =>'Approved' ));
				array_push($search, array(
					'fieldname'=>'date_start >=',
					'data'     =>common::format_date(common::get_today(), 'Y-m-d') ));

				$base_url   = 'http://localhost/copportal/event/new/page/';

			}elseif( $view_type == 'archive' ){

				array_push($search, array(
					'fieldname'=>'status',
					'data'     =>'Approved' ));
				//GET TOTAL NO. OF EVENTS
				$total_rows = $this->events_model->get_no_of_all_events();
				$base_url   = 'http://localhost/copportal/event/archive/page/';
			}

			if( $offset > ($total_rows) || $offset > $limit ){
				return $common->show_404();
			}

			if( $total_rows > 0 ){
				$params['offset']    = $offset;
				$params['limit']     = $limit;
				$params['search_by'] = $search;

				if( count($search) > 0 ){
					$result = $this->events_model->get_event_list($params);
				}else{
					$result = $this->events_model->get_event_list();
				}

				for ($i=0; $i<count($result); $i++) {
					//GET EVENT DESCRIPTION
					$description = $this->events_model->get_event_desc($result[$i]['event_id']);
					//GET EVENT OWNER
					$result_owner       = json_decode(json_encode( $this->users_model->get_user('id', $result[$i]['owner_id']) ), true);
					//GET DEPARTMENT
					$result_deparment   = json_decode(json_encode( $this->department_model->get_department(
						'dept_id', $result_owner[0]['dept_id']) ), true);

					$date_start  = $result[$i]['date_start'];
					$date_end    = $result[$i]['date_end'];

					//ADD THE MONTH OF START DATE INTO THE FILTER
					if( !in_array(common::format_date($date_start, 'F'), $filter) ){
						array_push($filter, common::format_date($date_start, 'F'));
					}
					//ADD THE DEPARTMENT INTO THE FILTER
					if( !in_array($result_deparment[0]['department'], $filter_dept) ){
						array_push($filter_dept, $result_deparment[0]['department']);
					}
					
					//DATE FORMATTED TO USER READABLE FORMAT
					$date = common::display_date($date_start, $date_end);

					//FORMAT TIME DISPLAY
					( $result[$i]['time_start'] == $result[$i]['time_end'] )?
						$time = $result[$i]['time_start']
					: $time = $result[$i]['time_start'].' - '.$result[$i]['time_end'];

					$result[$i]['time_display']   = $time;
					$result[$i]['date_display']   = $date;
					$result[$i]['description']    = character_limiter($description[0]['description'], 200);
					$result[$i]['filter']         = common::format_date($date_start, 'F');
					$result[$i]['filter']         = $result[$i]['filter'].' '.$result_deparment[0]['department'];
					$result[$i]['title']          = character_limiter($result[$i]['title'], 29);

					if( $view_type == 'archive' &&
							$result[$i]['date_start'] > common::format_date(common::get_today(), 'Y-m-d')){
							$result[$i]['status_display'] = 'New';
					}
					else if( $view_type == 'archive' &&
							$result[$i]['date_start'] == common::format_date(common::get_today(), 'Y-m-d')){
							$result[$i]['status_display'] = 'Ongoing';
					}
				}
				//SET UP PAGINATION
				$config['base_url'] = $base_url;
				$config['uri_segment'] = 4;
				$config['total_rows'] = $total_rows;
				$config['per_page'] = $limit;
				$config['full_tag_open'] = '<div class="row"><div class="col-md-12"><div class="pagination text-center"><ul>';
				$config['full_tag_close'] = '</ul></div></div></div>';
				$config['cur_tag_open'] = '<li><a href="javascript:void(0)" class="active">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['first_link'] = '<li>First';
				$config['last_link'] = '<li>Last';
				$config['prev_link'] = FALSE;
				$config['next_link'] = FALSE;
				$this->pagination->initialize($config);

				$data['event_new_list']     = $result;
				$data['filter']             = common::sort_month($filter);
				$data['filter_dept']        = $filter_dept;
				$data['artcore_pagination'] = $this->pagination->create_links();
			}
		}

		$data['page_header'] = array('title'=>$page, 'subtitle'=>'Schedule');

		$this->load->view('templates/pages/content_wrapper_open');
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/pages/content_wrapper_close');
	}
}
?>

