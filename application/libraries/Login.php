<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login {

	private $CI;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		$class->add('/assets/publishit/style.css', $class::STYLESHEET_REFERENCE);

		// add($url, $type, $other_param=array())

		$this->CI->session->keep_flashdata('requested_url');

		if ($_POST) {
			$this->handle_post();
		}
	}

	private function handle_post() {
		$form_id = $this->CI->input->post('form_id');
		$this->replacement_data = $this->CI->input->translate_prefix($form_id);
		$this->translated_data = $this->replacement_data;
		switch ($form_id) {
			case 'login_form':

				$this->login_user();

				if ($this->CI->session->flashdata('requested_url')) {
					redirect($this->CI->session->flashdata('requested_url'));
				}
				break;
			case 'logout':
				$this->CI->user->logout();
				header('Location: /');
				break;
			default:
				break;
		}
	} // handle_post()

	private function login_user() {
		$this->CI->user->login($this->translated_data['username'], $this->translated_data['password']);
	} // login()

	public function render() {
		return $this->CI->load->view('login', '', true);
	}

}
