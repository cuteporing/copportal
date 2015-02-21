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
	 * CREATE AN EVENT ALBUM MODAL
	 * @return modal
	 * --------------------------------------------
	 */
	public function upload_photo_modal()
	{
		$data['modal_id']     = 'upload-photo-modal';
		$data['modal_header'] = '<i class="fa fa-upload"></i> Upload photos';
		$this->load->view('templates/modal/modal_header', $data);
		// $this->load->view('templates/forms/gallery_upload_form', $data);
		$this->load->view('templates/modal/modal_footer', $data);
	}


	/**
	 * DISPLAY CREATE EVENT PAGE
	 * @return table
	 * --------------------------------------------
	 */
	public function create()
	{
		$data['events_category'] = $this->events_model->get_categories();
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

		$this->load->view('templates/forms/event_form', $data);
		// $this->upload_photo_modal();

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

			$date = common::display_date($date_start, $date_end);

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
			$this->upload_photo_modal();
		
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
		$limit  = 10;
		$filter = array();
		$params = array();
		$search = array();
		$common = new common;

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
			//GET EVENTS
			$result = $this->events_model->get_events('slug', $slug);

			if( $result ){
				//GET EVENT DESCRIPTION
				$result[0]['description'] = $this->events_model->get_event_desc(
							$result[0]['event_id']);
				//FORMAT DISPLAY DATE
				$result[0]['date_display'] = common::display_date(
							$result[0]['date_start'], $result[0]['date_end']);
				//GET EVENT MEMBERS
				$result[0]['members'] = $this->events_model->get_members(
							$result[0]['event_id']);
				$data['event_single']  = $result[0];
			}else{
				$common->show_404();
			}

		//EVENT LIST
		}else{
			( $offset == '' )? $offset = 0 : $offset = $offset;
			//DISPLAY LIST OF NEW EVENTS
			if( $view_type == 'new' ){
				//GET TOTAL NO. OF OPENED EVENTS
				$total_rows = $this->events_model->get_no_of_events('open');
				$search_data= 'open';
				$base_url   = 'http://localhost/copportal/event/new/page/';

			}elseif( $view_type == 'archive' ){
				//GET TOTAL NO. OF CLOSED EVENTS
				$total_rows = $this->events_model->get_no_of_events('close');
				$search_data= 'close';
				$base_url   = 'http://localhost/copportal/event/archive/page/';
			}

			if( $offset > ($total_rows) || $offset > $limit ){
				return $common->show_404();
			}

			if( $total_rows > 0 ){
				array_push($search, array(
						'fieldname'=>'status',
						'data'     =>$search_data
						));

				$params['offset']    = $offset;
				$params['limit']     = $limit;
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
					//DATE FORMATTED TO USER READABLE FORMAT
					$date = common::display_date($date_start, $date_end);

					$result[$i]['date_display']   = $date;
					$result[$i]['description']    = character_limiter($description[0]['description'], 200);
					$result[$i]['filter']         = common::format_date($date_start, 'F');
					$result[$i]['title']          = character_limiter($result[$i]['title'], 29);

					if( $view_type == 'archive' ){
						$result[$i]['status_display'] = ( $result[$i]['status'] == 'close' )? 'Closed' : 'Open';
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

