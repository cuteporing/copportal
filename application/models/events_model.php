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
	public function get_no_of_events($search_param = array())
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
				// $this->db->order_by("date_start", "desc");
				$this->db->from('cop_events');
			}else{
				$query = $this->db->get('cop_events');
			}

			return $this->db->count_all_results();
	}

	public function get_no_of_new_events($date)
	{
		$this->db->where('date_start >=', $date);
		$this->db->where('status', 'Approved');
		$this->db->from('cop_events');

		return $this->db->count_all_results();
	}

	public function get_no_of_all_events()
	{
		$this->db->where('status', 'Approved');
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

	public function get_confirmation($event_id)
	{
		$this->db->where('event_id', $event_id);
		$this->db->from('cop_event_confirmation');
		$query = $this->db->get();

		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
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
		$sql.= 'cop_beneficiaries.beneficiary, ';
		$sql.= 'cop_events_member.date_entered ';

		$this->db->select($sql);
		$this->db->from('cop_events_member');
		$this->db->join('cop_beneficiaries',
			'cop_events_member.id = cop_beneficiaries.id', 'left');
		$this->db->where('cop_events_member.event_id', $event_id);
		$this->db->order_by('cop_beneficiaries.beneficiary', 'asc');

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
			$this->db->from('cop_events');
			$this->db->join(
				'cop_category',
				'cop_events.category_id = cop_category.category_id',
				'left');
			$this->db->where($search_by, $data);
			$this->db->order_by('cop_events.date_start', 'asc');

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
	 * @param Array, $search_param
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
				$this->db->order_by("date_start", "desc");
				if( isset($search_param['limit']) && !empty($search_param['limit']) ){
					$query = $this->db->get('cop_events', $search_param['limit'], $search_param['offset']);
				}else{
					$this->db->from('cop_events');
					$query = $this->db->get();
				}
			}else{
				$this->db->order_by("date_start", "desc");
				$query = $this->db->get('cop_events');
			}

			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return FALSE;
			}
	}

	/**
	 * GET COMMENTS
	 * @param Array, $event_id
	 * @return Array | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function get_comments($event_id)
	{
		$this->db->where('event_id', $event_id);
		$this->db->from('cop_event_comments');
		$this->db->order_by("date_entered", "desc");
		$query = $this->db->get();

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
	public function add_event_member($beneficiary_data)
	{
		$this->db->trans_begin();
		foreach ($beneficiary_data as $data) {
			$this->db->insert('cop_events_member', $data);
		}

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
	 * DELETE EVENT DESCRIPTION
	 * @param Integer, $event_id
	 * --------------------------------------------
	 */
	public function delete_event_desc($id)
	{
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
		$this->db->delete('cop_description', $id);
		$this->db->delete('cop_events_member', $id);
		$this->db->delete('cop_event_confirmation', $id);

		// $this->delete_event_desc($event_id);

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
	public function update_events($event_data, $description_data=array(), $beneficiary_data=array())
	{
		$id = array('event_id'=>$event_data['event_id']);

		$this->db->trans_begin();
		$this->db->where('event_id', $event_data['event_id']);
		$this->db->update('cop_events', $event_data);
		$this->db->delete('cop_description', $id);
		$this->db->delete('cop_events_member', $id);
		$this->add_event_member( $beneficiary_data );
		//INSERT DESCRIPTION
		if( count($description_data) > 0 ){
			foreach ($description_data as $description) {
				$this->db->insert('cop_description', $description);
			}
		}

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
	 * UPDATE EVENT STATUS
	 * @param Array, $event_data
	 * @return Array
	 * --------------------------------------------
	 */
	public function update_event_status($event_data)
	{
		$this->db->trans_begin();
		$this->db->where('event_id', $event_data['event_id']);
		$this->db->update('cop_events', $event_data);

		if( $this->db->trans_status() === FALSE ){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 * CREATES AN EVENT
	 * @param Array, $event_data
	 * @return Array
	 * --------------------------------------------
	 */
	public function create_events($event_data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_events', $event_data);

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return FALSE;
		}
		else{
			$this->db->trans_commit();
			//GET LAST INSERTED ID

			$result = $this->get_last_event_id();
			foreach ($result as $row) { $unique_id = $row->event_id; }

			return $unique_id;
		}
	}

	/**
	 * ADDS A DESCRIPTION
	 * @param Array, $description_data
	 * @return Array
	 * --------------------------------------------
	 */
	public function add_event_description($description_data)
	{
		$this->db->trans_begin();
		foreach ($description_data as $data) {
			//INSERT DESCRIPTION
			$this->db->insert('cop_description', $data);
		}

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return FALSE;
		}
		else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function add_confirmation($confirmation_data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_event_confirmation', $confirmation_data);

		if( $this->db->trans_status() === FALSE )
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		else
		{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function add_comment($data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_event_comments', $data);

		if( $this->db->trans_status() === FALSE )
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		else
		{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function update_confirmation($confirmation_data){
		$this->db->trans_begin();
		$this->db->update('cop_event_confirmation', $confirmation_data);

		if( $this->db->trans_status() === FALSE )
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		else
		{
			$this->db->trans_commit();
			return TRUE;
		}
	}
}
?>
