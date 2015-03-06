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

class box extends CI_controller
{
	private $box_color;
	private $box_width;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * GET AVAILABLE BOX TYPES
	 * @param String, $type
	 * @return Array, $color
	 * --------------------------------------------
	 */
	public function get_available_type($type)
	{
		switch ($type) {
			case 'danger' : $color = array('class'=>'box box-danger');	break;
			case 'primary': $color = array('class'=>'box box-primary');	break;
			case 'success': $color = array('class'=>'box box-success');	break;
			case 'warning': $color = array('class'=>'box box-warning');	break;
			default: $color = array('class'=>'box box-primary');		break;
		}

		$this->box_color = $color;

		return $this->box_color;
	}

	/**
	 * GET COLUMN SIZE (1-12 only)
	 * @param Integer, $size
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_size($size)
	{
		if( $size > 12 ) { $size = 12; }

		$this->box_width = array('class'=>'col-md-'.$size);

		return $this->box_width;
	}

	/**
	 * DISPLAYS BOX HEADER
	 * @param String, $text
	 * @return <div>
	 * --------------------------------------------
	 */
	public function create_box_header($text)
	{
		$title = heading($text, '3', 'class="box-title"');

		// return div($title, array('class'=>'box-header'));
	}

	/**
	 * DISPLAYS BODY OF THE BOX
	 * @param String, $text
	 * @return <div>
	 * --------------------------------------------
	 */
	public function create_box_body($text)
	{
		return div($text, array('class'=>'box-body'));
	}

	/**
	 * DISPLAYS BOX FOOTER
	 * @param String, $text
	 * @return <div>
	 * --------------------------------------------
	 */
	public function create_box_footer($text)
	{
		return div($text, array('class'=>'box-footer'));
	}

	/**
	 * CREATES THE BOX
	 * @param String, $box
	 * @return <div>
	 * --------------------------------------------
	 */
	public function create_box($box)
	{
		// $box = div($box, $this->box_color);
		// $box = div($box, $this->box_width);

		// return $box;
	}

	/**
	 * DISPLAYS BOX
	 * @param String, $type
	 * @param Array, $details
	 * @return <div>
	 * --------------------------------------------
	 */
	public function view_box($type, $details = array())
	{
		$box = $this->create_box_header($details['header']);
		// $box.= $this->create_box_body($details['body']);
		// $box.= $this->create_box_body($details['footer']);

		return $this->create_box($box);
	}
}
?>