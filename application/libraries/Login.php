<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login {

	private $CI;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		$class->add('/assets/publishit/style.css', $class::STYLESHEET_REFERENCE);
		$class->add('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('/assets/publishit/js/script.js', $class::JAVASCRIPT_REFERENCE);

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
			case 'create_account':
				
				$this->translated_data['organization_id'] = 1;
				
				
				$this->create_account();
				redirect('/login');
				break;
			default:
				break;
		}
	} // handle_post()

	private function login_user() {
		$this->CI->user->login($this->translated_data['username'], $this->translated_data['password']);
	} // login()

	private function create_account() {
		$client = new SoapClient ("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl", array('trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE));
		try {	
				$this->translated_data['birthday'] =  date('Y-m-d\TH:i:sP', strtotime($this->translated_data['birthday']));
				$client->RegisterUser(array('user' => $this->translated_data));
			} catch (SoapFault $e){
				echo '<pre>';
				var_dump($client->__getLastResponse());
				var_dump($e);
				echo '</pre>';
			}

	}

	public function render() {
		return $this->CI->load->view('login', '', true);
	}

}


class inputUser {
	function inputUser($name, $username, $email, $birthday, $password, $organization_id) {
		$this->name = $name;
		$this->username = $username;
		$this->email = $email;
		$this->birthday = $birthday;
		$this->password = $password;
		$this->organization_id = $organization_id;
	}
}









