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

class Beneficiary_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function count_beneficiaries()
	{
		$this->db->where('deleted', 0);
		$this->db->from('cop_beneficiaries');
		return $this->db->count_all_results();
	}
}
?>
