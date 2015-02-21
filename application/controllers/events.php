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
		$this->load->model('events_model');
		$this->load->library('pagination');
	}

	/**
	 * SET OF ACTION BUTTON FOR TABLE DISPLAY
	 * @return Array
	 * --------------------------------------------
	 */
	static function action_btn($type='event')
	{
		if($type == 'members'){
			return array(
				0 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-ajax',
							'value'=>'delete'),
						1 => array(
							'data_name' =>'data-del-type',
							'value'=>'table')),
					'icon' =>'fa fa-times',
					'title'=>'Delete',
					'type' =>'danger',
					'url'  =>'events_ajax/member_delete/',
					)
				);
		}else{
			return array(
				0 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-toggle',
							'value'=>'tooltip'),
						1 => array(
							'data_name' =>'title',
							'value'=>'Event beneficiaries')
						),
					'icon' =>'fa fa-plus-square-o',
					'title'=>'Join',
					'type' =>'success',
					'url'  =>'account/events/manage/',
					),
				1 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-toggle',
							'value'=>'tooltip'),
						1 => array(
							'data_name' =>'title',
							'value'=>'Edit')
						),
					'icon' =>'fa fa-edit',
					'title'=>'Edit',
					'type' =>'info',
					'url'  =>'account/events/edit/',
					),
				2 => array(
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
					),
				3 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-ajax',
							'value'=>'edit'),
						1 => array(
							'data_name' =>'data-ajax-confirm-msg',
							'value'=>'Close the event?'),
						2 => array(
							'data_name' =>'data-toggle',
							'value'=>'tooltip'),
						3 => array(
							'data_name' =>'title',
							'value'=>'Close')),
					'icon' =>'fa fa-ban',
					'title'=>'Close',
					'type' =>'warning',
					'url'  =>'events_ajax/close/',
					)
				);
		}
	}

	/**
	 * DISPLAY CREATE EVENT PAGE
	 * @return table
	 * --------------------------------------------
	 */
	public function create()
	{
		$data['events_category'] = $this->events_model->get_categories();

		return $this->load->view('templates/forms/event_form', $data);
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

		$result[0]['date_start'] =  common::format_date($result[0]['date_start'], 'm/d/Y');
		$result[0]['date_end']   =  common::format_date($result[0]['date_end'], 'm/d/Y');

		$data['events_category'] = $this->events_model->get_categories();
		$data['result']          = $result[0];
		$data['result_desc']     = ($result_desc)? $result_desc : array();

		return $this->load->view('templates/forms/event_form', $data);
	}

	/**
	 * ADD BENEFICIARY ON EVENT
	 * @return table
	 * --------------------------------------------
	 */
	public function manage()
	{
		$event_id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));
		
		//IF THERE IS NO EVENT ID FROM URI, SHOW ERROR RECORD NOT FOUND
		if( $event_id == '' ){
			return $this->load->view('error/record_not_found');
		}

		//GET EVENT DETAILS
		$result_event = $this->events_model->get_events('event_id', $event_id);
		//GET EVENT DESCRIPTION
		$result_desc = $this->events_model->get_event_desc($event_id);
		//GET EVENT MEMBERS
		$result_members = $this->events_model->get_members($event_id);

		for($i=0; $i<count($result_members); $i++){
			$result_members[$i]['date_entered'] = common::format_date(
				$result_members[$i]['date_entered'], 'M d, Y');
			$result_members[$i]['name'] = '<b>'.$result_members[$i]['last_name'];
			$result_members[$i]['name'].='</b>, '.$result_members[$i]['first_name'];
			$result_members[$i]['result_id'] = $event_id.'/'.$result_members[$i]['id'];
		}

		$data['action_btn']   = self::action_btn('members');
		$data['event_id']     = $event_id;
		$data['result_event'] = $result_event[0];
		$data['result_desc']  = ($result_desc)? $result_desc : array();
		$data['table_name']   = 'Members';
		$data['fieldname']    = array('name', 'date_entered', 'action');
		$data['field_label']  = array('Name', 'Date joined', '&nbsp;');
		$data['result']       = $result_members;

		$this->load->view('account/events', $data);
		$this->load->view('templates/forms/event_member_form', $data);
		$this->load->view('templates/tables/data_tables_full', $data);
	}

	/**
	 * DISPLAY EVENT LIST PAGE
	 * @return table
	 * --------------------------------------------
	 */
	public function get_events()
	{
		$result = $this->events_model->get_events();

		for( $i=0; $i<count($result); $i++ ){
			$date_start= $result[$i]['date_start'];
			$date_end  = $result[$i]['date_end'];

			if( $date_start == $date_end ){
				$date = common::format_date($date_start, 'M d, Y');
			}else{
				$date_start_arr = explode('-', $date_start);
				$date_end_arr   = explode('-', $date_end);

				//IF MONTH AND YEAR FOR STARTING AND ENDING DATE IS THE SAME,
				//AND DAY IS DIFF DISPLAY AS:
				// <M d-d, YYYY>
				// <Feb 11-13, 2015>
				if( $date_start_arr[0] == $date_end_arr[0] &&
					$date_start_arr[1] == $date_end_arr[1] ){

					$date = common::format_date($date_start, 'M ');
					$date.= $date_start_arr[2].'-'.$date_end_arr[2].', '.$date_start_arr[0];

				//IF MONTH OR YEAR FOR STARTING AND ENDING DATE IS DIFFERENT,
				//DISPLAY AS:
				// <M d, YYYY - M d, YYY>
				// <Feb 11, 2015 - Feb 11, 2016>
				}elseif( $date_start_arr[0] != $date_end_arr[0] ||
					$date_start_arr[1] != $date_end_arr[1] ){

					$date = common::format_date($date_start, 'M d, Y').' - ';
					$date.= common::format_date($date_end, 'M d, Y');
				}
			}

			$result[$i]['date']      =  $date;
			$result[$i]['result_id'] = $result[$i]['event_id'];
		}

		$data['action_btn']   = self::action_btn('event');
		$data['table_name']   = 'Trainings and seminars';
		$data['fieldname']    = array('title','date', 'location', 'status', 'action');
		$data['field_label']  = array('Activity','Date', 'Venue', 'Status', '&nbsp;');
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
		$view_type  = str_replace('/', '', $this->uri->slash_segment(2, 'leading'));

		if( $view_type == 'new' ){
			$total_rows = $this->events_model->get_no_of_events('open');
			$limit      = 10;
			$filter     = array();

			if( $total_rows > 0 ){
				//GET THE OFFSET VIA URI SEGMENT
				$offset = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

				//SEARCH PARAMETERS FOR GETTING THE ANNOUNCEMENT LIST
				$params = array();
				$search = array();
				array_push($search, array(
					'fieldname'=>'status',
					'data'     =>'open'
					));

				$params['offset'] = ( $offset == '' )? 0 : $offset;
				$params['limit']  = $limit;
				$params['search_by'] = $search;

				$result = $this->events_model->get_event_list($params);

				for ($i=0; $i<count($result); $i++) {
					$description = $this->events_model->get_event_desc($result[$i]['event_id']);
					$date_start  = $result[$i]['date_start'];
					$date_end    = $result[$i]['date_end'];

					//ADD THE MONTH OF START DATE INTO THE FILTER
					if( !in_array(common::format_date($date_start, 'F'), $filter) ){
						array_push($filter, common::format_date($date_start, 'F'));
					}

					if( $date_start == $date_end ){
						$date = common::format_date($date_start, 'F d, Y');
					}else{
						$date_start_arr = explode('-', $date_start);
						$date_end_arr   = explode('-', $date_end);

						//IF MONTH AND YEAR FOR STARTING AND ENDING DATE IS THE SAME,
						//AND DAY IS DIFF DISPLAY AS:
						// <M d-d, YYYY>
						// <Feb 11-13, 2015>
						if( $date_start_arr[0] == $date_end_arr[0] &&
							$date_start_arr[1] == $date_end_arr[1] ){

							$date = common::format_date($date_start, 'F ');
							$date.= $date_start_arr[2].'-'.$date_end_arr[2].', '.$date_start_arr[0];

						//IF MONTH OR YEAR FOR STARTING AND ENDING DATE IS DIFFERENT,
						//DISPLAY AS:
						// <M d, YYYY - M d, YYY>
						// <Feb 11, 2015 - Feb 11, 2016>
						}elseif( $date_start_arr[0] != $date_end_arr[0] ||
							$date_start_arr[1] != $date_end_arr[1] ){

							$date = common::format_date($date_start, 'F d, Y').' - ';
							$date.= common::format_date($date_end, 'F d, Y');
						}
					}

					$result[$i]['date_display'] = $date;
					$result[$i]['description']  = character_limiter($description[0]['description'], 200);
					$result[$i]['filter']       = common::format_date($date_start, 'F');
					$result[$i]['title']        = character_limiter($result[$i]['title'], 29);
				}

				//SET UP PAGINATION
				$config['base_url'] = 'http://localhost/copportal/event/new/page/';
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
				$data['artcore_pagination'] = $this->pagination->create_links();
			}


		}elseif( $view_type == 'archive' ){

		}elseif( $view_type == 'title' ){
			$slug = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));

			//GET EVENTS
			$result = $this->events_model->get_events('slug', $slug);

			if( $result ){
				//GET EVENT DESCRIPTION
				$result[0]['description'] = $this->events_model->get_event_desc(
							$result[0]['event_id']);
				//GET EVENT MEMBERS
				$result[0]['members'] = $this->events_model->get_members(
							$result[0]['event_id']);
				$data['event_single']  = $result[0];
			}else{
				$common = new common;
				$common->show_404();
			}
		}

		$data['page_header'] = array('title'=>$page, 'subtitle'=>'Schedule');

		$this->load->view('templates/pages/content_wrapper_open');
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/pages/content_wrapper_close');
	}
}
?>

			
