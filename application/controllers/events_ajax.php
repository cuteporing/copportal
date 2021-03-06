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
				$label = str_replace('[]', '', ucfirst($field));

			if( empty($this->input->post($field)) || $this->input->post($field) == '' ){
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
			'beneficiary_id',
			'category',
			'budget',
			'event_date',
			'expected_output',
			'in_charge',
			'location',
			'time_end',
			'time_start',
			'title');

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			if( count($error_log) > 0 ) {
				for ($i=0; $i < count($error_log); $i++) {
					if( $error_log[$i]['input'] == 'beneficiary_id' ){
						$error_log[$i]['input']     = 'beneficiary_id[]';
						$error_log[$i]['error_msg'] = 'Beneficiary is required';
					}
				}
			}
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
			echo common::response_msg(200, 'redirect', '');
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
				'label'=>$row['first_name'].' '.$row['last_name'],
				'value'=>$row['id'],
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

		//EVENT DETAILS
		$date = trim(preg_replace('/\s+/',' ', $this->input->post('event_date')));
		$date = explode('-', $date);

		$date_start = common::format_date($date[0]);
		$date_end   = common::format_date($date[1]);
		$time_start = $this->input->post('time_start');
		$time_end   = $this->input->post('time_end');

		//status:
		//---------------------------
		//- Approved
		//- Denied
		//- Final confirmation
		//- Pending
		//- Revise
		if( $session_data['user_kbn'] == 30 ){
			$status       = 'Approved';
			$appr_cop_dir = 1;
			$appr_sps_dir = 1;
			$appr_cop_dir_name = '';
			$appr_sps_dir_name = $session_data['first_name'].' '.$session_data['last_name'];
		}else if ( $session_data['user_kbn'] == 20 ) {
			$status       = 'Final confirmation';
			$appr_cop_dir = 1;
			$appr_sps_dir = 0;
			$appr_cop_dir_name = $session_data['first_name'].' '.$session_data['last_name'];
			$appr_sps_dir_name = '';
		}else{
			$status       = 'Pending';
			$appr_cop_dir = 0;
			$appr_sps_dir = 0;
			$appr_cop_dir_name = '';
			$appr_sps_dir_name = '';
		}

		$event_data = array(
			'owner_id'        =>$session_data['id'],
			'title'           =>$this->input->post('title'),
			'status'          =>$status,
			'appr_cop_dir'    =>$appr_cop_dir,
			'appr_sps_dir'    =>$appr_sps_dir,
			'category_id'     =>$this->input->post('category'),
			'date_entered'    =>common::get_today(),
			'date_start'      =>$date_start,
			'date_end'        =>$date_end,
			'time_start'      =>$time_start,
			'time_end'        =>$time_end,
			'location'        =>ucfirst($this->input->post('location')),
			'in_charge'       =>$this->input->post('in_charge'),
			'expected_output' =>$this->input->post('expected_output'),
			'materials_needed'=>$this->input->post('materials_needed'),
			'budget'          =>$this->input->post('budget'),
			'slug'            =>url_title($this->input->post('title'), 'dash', TRUE)
			);

		//ADD EVENT
		$result_event = $this->events_model->create_events($event_data);

		//IF ADDING OF EVENT IS SUCCESSFUL
		if( $result_event ){
			$description_data  = array();
			$beneficiary_data  = array();

			$description = str_split($this->input->post('description'), 1000);
			$sequence = 1;
			$event_id = $result_event;

			foreach ($description as $text) {
				array_push($description_data, array(
					'event_id'   => $event_id,
					'description'=> $text,
					'sequence'   => $sequence
					)
				);

				$sequence++;
			}

			if( !empty($this->input->post('beneficiary_id')) ){

				foreach ($this->input->post('beneficiary_id') as $beneficiary) {
					array_push($beneficiary_data, array(
						'event_id'   => (int) $event_id,
						'id'         => (int) $beneficiary
						) );
				}
			}

			$confirmation_data = array(
				'event_id'     => (int) $event_id,
				'cop_director' => $appr_cop_dir_name,
				'sps_director' => $appr_sps_dir_name
				);

			//ADD THE EVENT DESCRIPTION
			$result_description = $this->events_model->add_event_description( $description_data );
			$result_beneficiary = $this->events_model->add_event_member( $beneficiary_data );
			$result_confirmation= $this->events_model->add_confirmation( $confirmation_data );

			//IF ADDING OF EVENT DESCRIPTION IS SUCCESSFUL
			if( $result_description && $result_beneficiary){
				// $local_storage = array('modal_id'=>$result_event);
				// echo common::response_msg(200, 'redirect', base_url().'account/events/edit/'.$result_event,$local_storage);
				echo common::response_msg(200, 'redirect', base_url().'account/events/manage/'.$event_id);
			}else{
				$this->delete($event_id);
				echo common::response_msg(200, 'error', 'Cannot create event');
			}
		}else{
			$this->delete($event_id);
			echo common::response_msg(200, 'error', 'Cannot create event');
		}
	}

	/**
	 * DELETES AN EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function delete($delete_id = '')
	{
		if( $delete_id != '' ){
			$event_id = $delete_id;
		}else{
			$event_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		}

		$events = $this->events_model->get_events('event_id', $event_id);

		$file_path  = $events[0]['file_path'];
		$file_path .= $events[0]['raw_name'];
		$file_path .= $events[0]['file_ext'];

		$result = $this->events_model->delete_event($event_id);
		if( $result ){
			@unlink($file_path);
			echo common::response_msg(200, 'redirect', base_url().'account/events/');
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

		//EVENT DETAILS
		$date = trim(preg_replace('/\s+/',' ', $this->input->post('event_date')));
		$date = explode('-', $date);

		$date_start = common::format_date($date[0]);
		$date_end   = common::format_date($date[1]);
		$time_start = $this->input->post('time_start');
		$time_end   = $this->input->post('time_end');

		//status:
		//---------------------------
		//- Approved
		//- Denied
		//- Final confirmation
		//- Pending
		//- Revise
		if( $session_data['user_kbn'] == 30 ){
			$status       = 'Approved';
			$appr_cop_dir = 1;
			$appr_sps_dir = 1;
			$appr_cop_dir_name = '';
			$appr_sps_dir_name = $session_data['first_name'].' '.$session_data['last_name'];
		}else if ( $session_data['user_kbn'] == 20 ) {
			$status       = 'Final confirmation';
			$appr_cop_dir = 1;
			$appr_sps_dir = 0;
			$appr_cop_dir_name = $session_data['first_name'].' '.$session_data['last_name'];
			$appr_sps_dir_name = '';
		}else{
			$status       = 'Pending';
			$appr_cop_dir = 0;
			$appr_sps_dir = 0;
			$appr_cop_dir_name = '';
			$appr_sps_dir_name = '';
		}

		$event_id = (int) $this->input->post('event_id');

		$event_data = array(
			'event_id'        =>$event_id,
			'title'           =>$this->input->post('title'),
			'status'          =>$status,
			'appr_cop_dir'    =>$appr_cop_dir,
			'appr_sps_dir'    =>$appr_sps_dir,
			'category_id'     =>(int) $this->input->post('category'),
			'date_start'      =>$date_start,
			'date_end'        =>$date_end,
			'time_start'      =>$time_start,
			'time_end'        =>$time_end,
			'location'        =>ucfirst($this->input->post('location')),
			'in_charge'       =>$this->input->post('in_charge'),
			'expected_output' =>$this->input->post('expected_output'),
			'materials_needed'=>$this->input->post('materials_needed'),
			'budget'          =>$this->input->post('budget'),
			'slug'            =>url_title($this->input->post('title'), 'dash', TRUE)
			);


		//IF ADDING OF EVENT IS SUCCESSFUL
		$description_data = array();
		$beneficiary_data = array();

		$description = str_split($this->input->post('description'), 1000);
		$sequence = 1;

		if( count($description) > 0){
			foreach ($description as $text) {
				array_push($description_data, array(
					'event_id'   => $event_id,
					'description'=> $text,
					'sequence'   => $sequence
					)
				);

				$sequence++;
			}
		}

		if( !empty($this->input->post('beneficiary_id')) ){

			foreach ($this->input->post('beneficiary_id') as $beneficiary) {
				array_push($beneficiary_data, array(
					'event_id'   => $event_id,
					'id'         => (int) $beneficiary
					) );
			}
		}

		$confirmation_data = array(
			'event_id'     => (int) $event_id,
			'cop_director' => $appr_cop_dir_name,
			'sps_director' => $appr_sps_dir_name
			);
		//EDIT EVENT
		$result_event = $this->events_model->update_events(
											$event_data,
											$description_data,
											$beneficiary_data);
		$result_confirmation= $this->events_model->update_confirmation( $confirmation_data );

		if( $result_event ){
				echo common::response_msg(200, 'redirect', base_url().'account/events/manage/'.$event_id);
		}else{
				echo common::response_msg(200, 'error', 'Cannot edit event');
		}
	}

	public function update_status()
	{
		$status_request = ucfirst(str_replace('/', '', $this->uri->slash_segment(3, 'leading')));

		switch ($status_request) {
			case 'Approved': $this->approved_event(); break;
			case 'Denied'  : $this->denied_event();   break;
			case 'Revise'  : $this->revise_event();   break;
			default: echo common::response_msg(200, 'error', 'Cannot updated event status'); break;
		}
	}

	/**
	 * REVISE EVENT STATUS
	 * @return JSON response
	 * --------------------------------------------
	 */
	public function revise_event()
	{
		$session_data = $this->session->userdata('logged_in');
		$event_id     = ucfirst(str_replace('/', '', $this->uri->slash_segment(4, 'leading')));
		$events       = $this->events_model->get_events('event_id', $event_id);

		//IF EVENT IS FOUND
		if( $events ){
			if( $session_data['user_kbn'] == 30 ){

				$event_data = array(
					'event_id'     => (int) $event_id,
					'status'       => 'Revise',
					'appr_cop_dir' => 0,
					'appr_sps_dir' => 0,
					);

			}else if( $session_data['user_kbn'] == 20 ){
				if( $events[0]['appr_sps_dir'] == 1 ){
					echo common::response_msg(200, 'error', 'Event has already been denied by the SPS Director');
					exit;
				}
				$event_data = array(
					'event_id'     => (int) $event_id,
					'status'       => 'Revise',
					'appr_cop_dir' => 0,
					'appr_sps_dir' => 0,
				);

			}

			$result_event = $this->events_model->update_event_status($event_data);

			if( $result_event ){
				$result_confirmation = $this->events_model->delete_confirmation($event_id);

				echo common::response_msg(200, 'redirect', base_url().'account/events/manage/'.$events[0]['event_id']);

			}else{
				echo common::response_msg(200, 'error', 'Cannot updated event');
			}
		}else{
			echo common::response_msg(200, 'error', 'Cannot updated event status');
		}
	}

	/**
	 * DENY EVENT STATUS
	 * @return JSON response
	 * --------------------------------------------
	 */
	public function denied_event()
	{
		$session_data = $this->session->userdata('logged_in');
		$event_id     = ucfirst(str_replace('/', '', $this->uri->slash_segment(4, 'leading')));
		$events       = $this->events_model->get_events('event_id', $event_id);

		//IF EVENT IS FOUND
		if( $events ){
			if( $session_data['user_kbn'] == 30 ){

				$event_data = array(
					'event_id'     => (int) $event_id,
					'status'       => 'Denied',
					'appr_cop_dir' => 1,
					'appr_sps_dir' => 1,
					);

			}else if( $session_data['user_kbn'] == 20 ){
				if( $events[0]['appr_sps_dir'] == 1 && $events[0]['status'] == 'Denied' ){
					echo common::response_msg(200, 'error', 'Event has already been denied byt the SPS Director');
					exit;
				}
				$event_data = array(
					'event_id'     => (int) $event_id,
					'status'       => 'Denied',
					'appr_cop_dir' => 1,
					'appr_sps_dir' => 0,
				);

			}

			$result_event = $this->events_model->update_event_status($event_data);

			if( $result_event ){
				$result_confirmation = $this->events_model->delete_confirmation($event_id);
				echo common::response_msg(200, 'redirect', base_url().'account/events/manage/'.$events[0]['event_id']);

			}else{
				echo common::response_msg(200, 'error', 'Cannot updated event');
			}
		}else{
			echo common::response_msg(200, 'error', 'Cannot updated event status');
		}
	}

	/**
	 * APPROVE EVENT STATUS
	 * @return JSON response
	 * --------------------------------------------
	 */
	public function approved_event()
	{
		$session_data = $this->session->userdata('logged_in');
		$event_id     = ucfirst(str_replace('/', '', $this->uri->slash_segment(4, 'leading')));
		$events       = $this->events_model->get_events('event_id', $event_id);

		if( $events ){
			if( $session_data['user_kbn'] == 30 ){

				$event_data = array(
					'event_id'     => (int) $event_id,
					'status'       => 'Approved',
					'appr_cop_dir' => 1,
					'appr_sps_dir' => 1,
					);

				$confirmation_data = array(
					'event_id'     => (int) $event_id,
					'sps_director' => $session_data['first_name'].' '.$session_data['last_name']
					);
			}else if( $session_data['user_kbn'] == 20 ){
				if( $events[0]['appr_sps_dir'] == 1 && $events[0]['status'] == 'Approved' ){
					echo common::response_msg(200, 'error', 'Event has already been approved byt the SPS Director');
					exit;
				}
				$event_data = array(
					'event_id'     => (int) $event_id,
					'status'       => 'Final confirmation',
					'appr_cop_dir' => 1,
					'appr_sps_dir' => 0,
				);

				$confirmation_data = array(
					'event_id'     => (int) $event_id,
					'cop_director' => $session_data['first_name'].' '.$session_data['last_name']
					);
			}

			$result_event = $this->events_model->update_event_status($event_data);

			if( $result_event ){
				$result_confirmation = $this->events_model->update_confirmation($confirmation_data);
				echo common::response_msg(200, 'redirect', base_url().'account/events/manage/'.$events[0]['event_id']);

			}else{
				echo common::response_msg(200, 'error', 'Cannot updated event');
			}
		}else{
			echo common::response_msg(200, 'error', 'Cannot updated event status');
		}
	}

	/**
	 * UPLOADS A PHOTO
	 * @param Array, $params
	 * @return JSON response
	 * --------------------------------------------
	 */
	public function upload_photo($params = array())
	{
		$status = "";
		$msg = "";
		$file_element_name = 'userfile';

		if ($status != "error"){
			$upload_path   = ( isset($params['upload_path']) )?   $params['upload_path']   : './'.common::get_constants('imgPath',   'EVENT');
			$allowed_types = ( isset($params['allowed_types']) )? $params['allowed_types'] : common::get_constants('imgConfig', 'ALLOWED_TYPES');
			$max_size      = ( isset($params['max_size']) )?      $params['max_size']      : common::get_constants('imgConfig', 'MAX_SIZE');
			$max_width     = ( isset($params['max_width']) )?     $params['max_width']     : common::get_constants('imgConfig', 'MAX_WIDTH');
			$max_height    = ( isset($params['max_height']) )?    $params['max_height']    : common::get_constants('imgConfig', 'MAX_HEIGHT');

			$config['upload_path']   = $upload_path;
			$config['allowed_types'] = $allowed_types;
			$config['max_size']	     = $max_size;
			$config['max_width']     = $max_width;
			$config['max_height']    = $max_height;
			$config['encrypt_name'] = FALSE;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($file_element_name)){
				$status = 'error';
				$msg    =  $this->upload->display_errors('', '');
				echo common::response_msg(200, 'error', $msg);
			}else{
				$data = $this->upload->data();
				$image_path = $data['full_path'];
				if(file_exists($image_path)){
					//SAVE GALLERY PHOTO TO DATABASE
					$this->save_photo($data);
				}else{
					echo common::response_msg(200, 'error', 'Something went wrong when saving the file, please try again.');
				}
			}
			@unlink($_FILES[$file_element_name]);
		}
	}

	/**
	 * SAVE UPLOADED IMAGE INFO ON DATABASE
	 * @param Array, $uploaded_photo
	 * @return JSON response
	 * --------------------------------------------
	 */
	public function save_photo($uploaded_photo)
	{
		$event_id   = $this->input->post('event_id');

		$data = array(
			'event_id'  =>$event_id,
			'raw_name'  =>$uploaded_photo['raw_name'],
			'file_path' =>common::get_constants('imgPath', 'EVENT'),
			'file_ext'  =>$uploaded_photo['file_ext'],
			);

		$events = $this->events_model->get_events('event_id', $event_id);

		$result = $this->events_model->update_events($data);

		if( $result['status'] == 'success' ){
			if( !is_null($events[0]['raw_name']) ){
				$file_path  = $events[0]['file_path'];
				$file_path .= $events[0]['raw_name'];
				$file_path .= $events[0]['file_ext'];
				@unlink($file_path);
			}
			echo common::response_msg(200, 'refresh', '');
		}else{
			echo common::response_msg(200, 'error', 'Something went wrong when saving the file, please try again.');
		}
	}

	/**
	 * GET FIRST DAY OF THE MONTH IN 'D' FORMAT
	 * @param Integer, $month
	 * @param Integer, $year
	 * @return Date
	 * --------------------------------------------
	 */
	public function getFirstDay($month, $year)
	{
		$date = $month.'/1/'.$year;
		return date('D', strtotime($date));
	}

	/**
	 * GET last DAY OF THE MONTH IN 'D' FORMAT
	 * @param Integer, $month
	 * @param Integer, $day
	 * @param Integer, $year
	 * @return Date
	 * --------------------------------------------
	 */
	public function getLastDay($month, $day, $year)
	{
		$date = $month.'/'.$day.'/'.$year;
		return date('D', strtotime($date));
	}

	/**
	 * GET THE NUMBER OF DAYS IN A GREGORIAN CAL
	 * @param Integer, $month
	 * @param Integer, $year
	 * @return Date
	 * --------------------------------------------
	 */
	public function getCalendarDays($month, $year)
	{
		return cal_days_in_month(CAL_GREGORIAN, $month, $year);
	}

	/**
	 * CREATE CALENDAR
	 * @return Calendar w/ events
	 * --------------------------------------------
	 */
	public function calendar()
	{
		$month  = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));
		$year   = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));

		$calendar = array();
		$calendarFinal   = array();

		$firstDay = $this->getFirstDay($month, $year);
		$noOfDays = $this->getCalendarDays($month, $year);
		$lastDay  = $this->getLastDay($month, $noOfDays, $year);

		if( $month < 10 ){
			$month = "0" + $month;
		}

		switch ($firstDay) {
			case 'Mon':
				array_push($calendar, '<td date-month="'.$month.'" date-day="1">1</td>');
				break;
			case 'Tue':
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td date-month="'.$month.'" date-day="1">1</td>');
				break;
			case 'Wed':
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td date-month="'.$month.'" date-day="1">1</td>');
				break;
			case 'Thu':
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td date-month="'.$month.'" date-day="1">1</td>');
				break;
			case 'Fri':
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td date-month="'.$month.'" date-day="1">1</td>');
				break;
			case 'Sat':
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td date-month="'.$month.'" date-day="1">1</td>');
				break;
			case 'Sun':
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td date-month="'.$month.'" date-day="1">1</td>');
				break;
			default:
				# code...
				break;
		}

		for($i = 2; $i < $noOfDays; $i++){
			if( $i < 10 ){
				$currentDay = "0"+$i;
			}else{
				$currentDay = $i;
			}
			array_push($calendar, '<td date-month="'.$month.'" date-day="'.$currentDay.'">'.$currentDay.'</td>');
		}

		if( $noOfDays < 10 ){
			$noOfDays = "0" + $noOfDays;
		}

		switch ($lastDay) {
			case 'Mon':
				array_push($calendar, '<td date-month="'.$month.'" date-day="'.$noOfDays.'">'.$noOfDays.'</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				break;
			case 'Tue':
				array_push($calendar, '<td date-month="'.$month.'" date-day="'.$noOfDays.'">'.$noOfDays.'</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				break;
			case 'Wed':
				array_push($calendar, '<td date-month="'.$month.'" date-day="'.$noOfDays.'">'.$noOfDays.'</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				break;
			case 'Thu':
				array_push($calendar, '<td date-month="'.$month.'" date-day="'.$noOfDays.'">'.$noOfDays.'</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				break;
			case 'Fri':
				array_push($calendar, '<td date-month="'.$month.'" date-day="'.$noOfDays.'">'.$noOfDays.'</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				break;
			case 'Sat':
				array_push($calendar, '<td date-month="'.$month.'" date-day="'.$noOfDays.'">'.$noOfDays.'</td>');
				array_push($calendar, '<td class="no-border">&nbsp;</td>');
				break;
			case 'Sun':
				array_push($calendar, '<td date-month="'.$month.'" date-day="'.$noOfDays.'">'.$noOfDays.'</td>');
				break;
			default:
				break;
		}

		$result = $this->events_model->get_events_by_date($month, $year);

		if( $result ){
			for($i=0; $i < count($result); $i++){
				$result[$i]['date_month'] = common::format_date(
					$result[$i]['date_start'], 'm');

				$result[$i]['date_day'] = common::format_date(
					$result[$i]['date_start'], 'd');

				$date_start= $result[$i]['date_start'];
				$date_end  = $result[$i]['date_end'];

				$date = common::display_date($date_start, $date_end);

				$description = $this->events_model->get_event_desc($result[$i]['event_id']);

				$result[$i]['date']        =  $date;
				$result[$i]['description'] = $description[0]['description'];
				$result[$i]['slug']        = base_url().'event/title/'.$result[$i]['slug'];
			}
			$calendarFinal['events'] = $result;
		}else{
			$calendarFinal['events'] = array($month, $year);
		}
		
		$calendarFinal['dates']  = $calendar;

		echo json_encode($calendarFinal);
	}

	public function comment()
	{
		$session_data = $this->session->userdata('logged_in');
		$event_id     = $this->input->post('event_id');
		$comment      = $this->input->post('comment');

		( $session_data['gender'] == 'Male' )?
			$img = 'assets/img/avatar5.png'
		: $img = 'assets/img/avatar3.png';

		$data = array(
			'event_id' => $event_id,
			'name'     => $session_data['first_name'].' '.$session_data['last_name'],
			'text'     => $comment,
			'img'      => $img
			);

		$result = $this->events_model->add_comment($data);

		if( $result ){
			$date = new DateTime();
			$data['datetime'] = date_format($date, 'H:i');
			$data['img']      = base_url().$data['img'];
			echo common::response_msg(200, 'add_comment', '',$data);
		}else{
			echo common::response_msg(200, 'error', 'Unable to send message');
		}

	}
}
?>