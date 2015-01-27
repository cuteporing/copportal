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

		if( $unique_id == '' || is_null($unique_id)){ $unique_id++; }

		// foreach ($description_data as $data) {
		// 	$data['id'] = $unique_id;
		// 	//INSERT DESCRIPTION
		// 	$this->db->insert('cop_announcement_description', $data);
		// }

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
}
?>
