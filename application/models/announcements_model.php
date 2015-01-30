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

class Announcements_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * GET LAST INSERTED announcement ID
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_last_announcement_id()
	{
		$sql = 'MAX(`announcement_id`) AS id';
		$this->db->select($sql);
		$this->db->from('cop_announcements');
		$query = $this->db->get();

		return $query->result();
	}

	/**
	 * GET ANNOUNCEMENT DESCRIPTION BASED ON THE ANNOUNCEMENT ID
	 * @param Integer, $announcement_id
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_announcement_desc($announcement_id)
	{
		$this->db->where('announcement_id', $announcement_id);
		$this->db->from('cop_announcement_description');
		$this->db->limit(1);
		$query = $this->db->get();

		if( $query->num_rows() == 1 ){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	/**
	 * GET ANNOUNCEMENTS
	 * @param String, $search_by
	 * @param String, $data
	 * @return Array | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function get_announcements($search_by='', $data='')
	{
		if( $search_by == '' ){
			$query = $this->db->get('cop_announcements');
			// $this->db->order_by("date_entered", "desc");
			return $query->result_array();
		}else{
			$this->db->where($search_by, $data);
			$this->db->from('cop_announcements');
			$this->db->limit(1);
			$query = $this->db->get();

			if( $query->num_rows() == 1 ){
				return $query->result();
			}else{
				return FALSE;
			}
		}
	}

	/**
	 * CREATES AN ANNOUNCEMENT
	 * @param Array, $announcement_data
	 * @param Array, $description_data
	 * @return Array
	 * --------------------------------------------
	 */
	public function create_announcements($announcement_data, $description_data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_announcements', $announcement_data);

		//GET LAST INSERTED ID
		$result = $this->get_last_announcement_id();

		foreach ($result as $row) { $unique_id = $row->id; }

		if( $unique_id == '' || is_null($unique_id)){ (int) $unique_id++; }

		foreach ($description_data as $data) {
			$data['announcement_id'] = $unique_id;
			//INSERT DESCRIPTION
			$this->db->insert('cop_announcement_description', $data);
		}

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return array(
				'status'=>'error',
				'msg'   =>$this->db->_error_message()
				);
		}else{
			$this->db->trans_commit();
			return array(
				'status'=>'success',
				'msg'   =>$announcement_data['title'].' has been created'
				);
		}
	}

	/**
	 * UPDATE ANNOUNCEMENTS DETAILS
	 * @param Array, $announcement_data
	 * @param Array, $description_data
	 * @return Array
	 * --------------------------------------------
	 */
	public function update_announcements($announcement_data, $description_data)
	{
		$this->db->trans_begin();
		$this->db->where('announcement_id', $announcement_data['announcement_id']);
		$this->db->update('cop_announcements', $announcement_data);
		//DELETE ALL EVENT DESCRIPTION FOR THE EVENT
		$this->delete_announcement_desc($announcement_data['announcement_id']);

		foreach ($description_data as $data) {
			$data['announcement_id'] = $announcement_data['announcement_id'];
			//INSERT DESCRIPTION
			$this->db->insert('cop_announcement_description', $data);
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
			return array(
				'status'=>'success',
				'msg'   =>$announcement_data['title'].' has been updated'
				);
		}
	}

	/**
	 * DELETE ANNOUNCEMENT DESCRIPTION
	 * @param Integer, $announcement_id
	 * --------------------------------------------
	 */
	public function delete_announcement_desc($announcement_id)
	{
		$id = array('announcement_id'=>$announcement_id);
		$this->db->delete('cop_announcement_description', $id);
	}

	/**
	 * DELETE ANNOUNCEMENT
	 * @param Integer, $announcement_id
	 * --------------------------------------------
	 */
	public function delete_announcement($announcement_id)
	{
		$id = array('announcement_id'=>$announcement_id);

		$this->db->trans_begin();
		$this->db->delete('cop_announcements', $id);
		$this->delete_announcement_desc($announcement_id);

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
}
?>
