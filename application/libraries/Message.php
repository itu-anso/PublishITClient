<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Message {

	private $CI;

	private $error_messages = array();

	private $has_error;

	public function __construct() {
		// get the framework and is th eactual link to the functions of the framework
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		$class->add('/assets/Message/Message.css', $class::STYLESHEET_REFERENCE);
		$class->add('/assets/Message/js/Message.js', $class::JAVASCRIPT_REFERENCE);
		$this->has_error = false;
	}

	public function set_error_message($error_message) {
		array_push($this->error_messages, $error_message);
		$this->has_error = true;
	}

	public function get_rendered_error_messages() {
		return $this->CI->load->view('message', array('error_messages' => $this->error_messages), true);
	}

	public function has_error() {
		return $this->has_error;
	}

	public function render() {
		return $this->load->view('message', '', true);
	}

}
