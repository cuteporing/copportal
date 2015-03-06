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
	public function get_no_of_events($status, $type = 'general')
	{
		//GET ONLY THE NUMBER OF APPROVED EVENTS
		//W/ STATUS OPEN OR CLOSES
		if( $type == 'view' ) {
			$this->db->where('status', $status);
			$this->db->where('appr_sps_dir', 1);
		}else{
			$this->db->where('status', $status);
		}
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
			case 'new'     : $fieldname = 'status'; break;
			case 'approved': $fieldname = 'status'; break;
			case 'denied'  : $fieldname = 'status'; break;
			default: return; break;
		}
		$this->db->where($fieldname, $status);
		$this->db->from('cop_events_member');
		return $this->db->count_all_results();
	}

	/**
	 * GET MEMBERS
	 * @param Integer, $event_id
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_members($event_id)
	{
		$sql = 'cop_beneficiaries.id,';
		$sql.= 'cop_beneficiaries.first_name, ';
		$sql.= 'cop_beneficiaries.last_name, ';
		$sql.= 'cop_beneficiaries.gender, ';
		$sql.= 'cop_events_member.date_entered ';

		$this->db->select($sql);
		$this->db->from('cop_events_member');
		$this->db->join('cop_beneficiaries',
			'cop_events_member.id = cop_beneficiaries.id', 'left');
		$this->db->where('cop_events_member.event_id', $event_id);
		$this->db->order_by('cop_beneficiaries.last_name', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function check_member($event_id, $id)
	{
		$this->db->where('event_id', $event_id);
		$this->db->where('id', $id);
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
	 * GET EVENT DESCRIPTION BASED ON THE EVENT ID
	 * @param Integer, $event_id
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_event_desc($event_id)
	{
		$this->db->where('event_id', $event_id);
		$this->db->from('cop_description');
		$this->db->order_by("sequence", "asc");
		$query = $this->db->get();

		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	/**
	 * GET EVENTS
	 * @param String, $search_by
	 * @param String, $data
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
			$this->db->order_by("date_start", "asc");
			$query = $this->db->get();

			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return FALSE;
			}
		}
	}

	public function get_events_by_date($month, $year){
			$this->db->where('YEAR(date_start)', $year);
			$this->db->where('MONTH(date_start)', $month);
			$this->db->from('cop_events');
			$this->db->order_by("date_start", "asc");
			$query = $this->db->get();

			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return FALSE;
			}
	}

	/**
	 * GET EVENT LIST
	 * @param Array, $params
	 * @return Array | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function get_event_list($search_param = array())
	{

			if( count($search_param) > 0 ){
				if( isset($search_param['search_by']) && count($search_param['search_by']) > 0 ){
						foreach ($search_param['search_by'] as $param) {
							$this->db->where(
								$param['fieldname'],
								$param['data']
							);
						}
				}
				$this->db->where('appr_sps_dir', 1);
				$this->db->order_by("date_start", "desc");
				$query = $this->db->get('cop_events', $search_param['limit'], $search_param['offset']);
			}else{
				$query = $this->db->get('cop_events');
			}

			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return FALSE;
			}
	}

	/**
	 * ADD BENEFICIARY TO AN EVENT
	 * @param Array, $data
	 * @return Array
	 * --------------------------------------------
	 */
	public function add_event_member($data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_events_member', $data);

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
				'msg'   =>''
				);
		}
	}

	/**
	 * REMOVE BENEFICIARY FROM AN EVENT
	 * @param Integer, $event_id
	 * --------------------------------------------
	 */
	public function delete_event_member($event_id, $id)
	{
		$this->db->trans_begin();

		$this->db->where('event_id', $event_id);
		$this->db->where('id', $id);
		$this->db->delete('cop_events_member');

		if( $this->db->trans_status() === FALSE )
		{
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 * DELETE EVENT DESCRIPTION
	 * @param Integer, $event_id
	 * --------------------------------------------
	 */
	public function delete_event_desc($event_id)
	{
		$id = array('event_id'=>$event_id);
		$this->db->delete('cop_description', $id);
	}

	/**
	 * DELETE EVENT DETAILS
	 * @param Integer, $event_id
	 * --------------------------------------------
	 */
	public function delete_event($event_id)
	{
		$id = array('event_id'=>$event_id);

		$this->db->trans_begin();
		$this->db->delete('cop_events', $id);
		$this->delete_event_desc($event_id);

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 * CLOSE EVENT
	 * @param Array, $event_data
	 * @return Array
	 * --------------------------------------------
	 */
	public function close_events($event_data)
	{
		$this->db->trans_begin();
		$this->db->where('event_id', $event_data['event_id']);
		$this->db->update('cop_events', $event_data);

		if( $this->db->trans_status() === FALSE )
		{
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 * UPDATE EVENT DETAILS
	 * @param Array, $event_data
	 * @param Array, $description_data
	 * @return Array
	 * --------------------------------------------
	 */
	public function update_events($event_data, $description_data=array())
	{
		$this->db->trans_begin();
		$this->db->where('event_id', $event_data['event_id']);
		$this->db->update('cop_events', $event_data);

		if( count($description_data) > 0 ){
			//DELETE ALL EVENT DESCRIPTION FOR THE EVENT
			$this->delete_event_desc($event_data['event_id']);

			foreach ($description_data as $data) {
				$data['event_id'] = $event_data['event_id'];
				//INSERT DESCRIPTION
				$this->db->insert('cop_description', $data);
			}
		}

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return array(
				'status'=>'error',
				'msg'   =>'Cannot update the event'
				);
		}else{
			$this->db->trans_commit();
			
				if( isset($event_data['title']) ){
					return array(
						'status'=>'success',
						'msg'   =>'"'.$event_data['title'].'" has been updated'
					);
				}else{
					return array(
						'status'=>'success',
						'msg'   =>'Event has been updated'
					);
				}
		}
	}

	/**
	 * CREATES AN EVENT
	 * @param Array, $event_data
	 * @param Array, $description_data
	 * @return Array
	 * --------------------------------------------
	 */
	public function create_events($event_data, $description_data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_events', $event_data);

		//GET LAST INSERTED ID
		$result = $this->get_last_event_id();

		foreach ($result as $row) { $unique_id = $row->event_id; }

		if( $unique_id == '' || is_null($unique_id)){ $unique_id++; }

		foreach ($description_data as $data) {
			$data['event_id'] = $unique_id;
			//INSERT DESCRIPTION
			$this->db->insert('cop_description', $data);
		}

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
				'msg'   =>$unique_id
				);
		}
	}
}
?>
