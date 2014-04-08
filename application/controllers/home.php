<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 *
	 */
	public function index() {

		$this->data['content'] = '';
		$this->render();
	}

	public function render() {
		$this->load->view('default', $this->data);
	}
}