<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Publications {

	private $CI;

	private $data;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
	}

	public function render() {
		return $this->CI->load->view('publications', $this->data, true);
	}
}