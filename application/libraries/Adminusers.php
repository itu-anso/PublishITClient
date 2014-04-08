<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Adminusers {

	private $CI;

	public function init() {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;

		if ($_POST) {
			$this->handle_post();
		}
	}

	private function handle_post() {
		$form_id = $this->CI->input->post('form_id');
		$this->replacement_data = $this->CI->input->translate_prefix($form_id);
		$this->translated_data = $this->replacement_data;

		switch ($form_id) {
			case 'new_user_form':
				$this->CI->user->new_user($this->translated_data);
				redirect('/brugere');
			case 'new_password_form':
				$this->CI->user->new_password($this->translated_data);
				redirect('/brugere');
			default:
				break;
		}
	} // handle_post()

	public function render() {
		return $this->CI->load->view('adminusers', '', true);
	}

}
