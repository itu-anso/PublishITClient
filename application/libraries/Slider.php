<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Slider {

	private $CI;

	private $data;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;

		$this->CI->headerqueue->add('/assets/Slider/Slider.css', $class::STYLESHEET_REFERENCE);

		$this->load_images();
	}

	private function load_images() {
		$this->CI->load->helper('directory');
		$this->data['images'] = directory_map('./assets/Slider/images');
	} // load_menu()

	public function render() {
		return $this->CI->load->view('slider', $this->data, true);

	}

}
