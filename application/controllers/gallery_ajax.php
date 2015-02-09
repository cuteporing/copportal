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

class gallery_ajax extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('gallery_model');
	}

	public function album_create()
	{
		$data = array(
			'title'        => $this->input=>post('title'),
			'description'  => $this->input->post('description'),
			'date_entered' => common::get_today(),
			'date_modified'=> common::get_today(),
			'slug'         => url_title($this->input->post('title'), 'dash', TRUE)
			);

	}
}
?>