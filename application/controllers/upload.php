<?php

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper('url');
	}

	function index()
	{
		$this->load->view('pages/upload', array('error' => ' ' ));
	}

	function do_upload()
	{
		$config['upload_path'] = './uploads/';
		print_r($config['upload_path']);
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('pages/upload', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('pages/upload_success', $data);
		}
	}
}
?>