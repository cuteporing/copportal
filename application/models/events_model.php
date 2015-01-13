<?php
/*********************************************************************************
** The contents of this file are subject to the ______________________
 * Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: ______________________
 * The Initial Developer of the Original Code is Krishia Valencia.
 * Portions created by KBVCodes are Copyright (C) KBVCodes.
 * All Rights Reserved.
 *
 ********************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * GET NO. OF EVENTS PER STATUS
	 * - ongoing
	 * - closed
	 * @return Integer
	 * --------------------------------------------
	 */
	public function get_no_of_events($status)
	{
		$this->db->where('status', $status);
		$this->db->from('cop_events');
		return $this->db->count_all_results();
	}

	/**
	 * GET NO. OF MEMBER PER STATUS
	 * - new
	 * - approved
	 * - denied
	 * @return Integer
	 * --------------------------------------------
	 */
	public function get_no_of_member($status)
	{
		switch ($status) {
			case 'new'     : $fieldname = 'status';					break;
			case 'approved': $fieldname = 'status';					break;
			case 'denied'  : $fieldname = 'status';					break;
			default: return; break;
		}
		$this->db->where($fieldname, $status);
		$this->db->from('cop_events_member');
		return $this->db->count_all_results();
	}

	/**
	 * GET CATEGORIES
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_categories()
	{
		$query = $this->db->get('cop_category');
		return $query->result_array();
	}

	/**
	 * GET LAST INSERTED EVENT ID
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_last_event_id()
	{
		$sql = 'MAX(`event_id`) AS event_id';
		$this->db->select($sql);
		$this->db->from('cop_events');
		$query = $this->db->get();

		return $query->result();
	}

	/**
	 * GET EVENTS
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_events($search_by='', $data='')
	{
		if( $search_by == '' ){
			$query = $this->db->get('cop_events');
			return $query->result_array();
		}else{
			$this->db->where($search_by, $data);
			$this->db->from('cop_events');
			$this->db->limit(1);

			$query = $this->db->get();

			if( $query->num_rows() == 1 ){
				return $query->result();
			}else{
				return FALSE;
			}
		}
		
	}

	public function update_events()
	{

	}

	public function create_events($event_data, $description_data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_events', $event_data);

		//GET LAST INSERTED ID
		$result = $this->get_last_event_id();

		foreach ($result as $row) { $unique_id = $row->event_id; }

		if( $unique_id == '' || is_null($unique_id)){ $unique_id++; }

		$description_data['event_id'] = $unique_id;
		//INSERT DESCRIPTION
		$this->db->insert('cop_description', $description_data);

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return array(
				'status'=>'error',
				'msg'   =>'Cannot create an event'
				);
		}else{
			$this->db->trans_commit();
			return array(
				'status'=>'success',
				'msg'   =>$event_data['title'].' has been created'
				);
		}
	}
}
?>
