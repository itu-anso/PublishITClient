<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Message {

	/**
	 * Holds a reference to the codeigniter framework.
	 * 
	 * @var Object
	 */
	private $CI;

	/**
	 * An array containing all created error messages, from a single request.
	 * 
	 * @var array
	 */
	private $error_messages = array();

	/**
	 * Whether the message module contains any errors.
	 * 
	 * @var bool
	 */
	private $has_error;

	/**
	 * Constructor for the message class.
	 * 
	 */
	public function __construct() {
		// get the framework and is th eactual link to the functions of the framework
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		$class->add('/assets/Message/Message.css', $class::STYLESHEET_REFERENCE);
		$class->add('/assets/Message/js/Message.js', $class::JAVASCRIPT_REFERENCE);
		$this->has_error = false;
	}

	/**
	 * Puts an error message onto the error_messages array.
	 * 
	 * @param string $error_message an error message to be added to the error stack.
	 */
	public function set_error_message($error_message) {
		array_push($this->error_messages, $error_message);
		$this->has_error = true;
	}

	/**
	 * Returns true if the message contains any errors. False otherwise.
	 * 
	 * @return boolean Does message contain any errors or not.
	 */
	public function has_error() {
		return $this->has_error;
	}

	/**
	 * Returns all the error messages.
	 * 
	 * @return string a view containing the errors.
	 */
	public function render() {
		return $this->CI->load->view('message', array('error_messages' => $this->error_messages), true);
	}
}
