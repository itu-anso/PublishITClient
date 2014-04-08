<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AdminMenu {

	private $CI;

	public function init() {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
	}

	public function render() {
		return $this->CI->load->view('adminmenu/adminmenu', '', true);

	}

}
