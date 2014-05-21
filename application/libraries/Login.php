<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login {

	/**
	 * Array which holds data for the view.
	 * 
	 * @var array
	 */
	private $data;
	
	/**
	 * Holds a reference to the codeigniter framework.
	 * 
	 * @var Object
	 */
	private $CI;

	/**
	 * Init the login module called by the page model.
	 * 
	 * @param  int $module_id The module id
	 */
	public function init($module_id=null) {
		// get the framework and is th eactual link to the functions of the framework
		$this->CI =& get_instance();
		// Headerqueuue makes it possible to make an add to the header ect.
		$class = $this->CI->headerqueue;

		$class->add('/assets/publishit/style.css', $class::STYLESHEET_REFERENCE);
		$class->add('/assets/login/login.css', $class::STYLESHEET_REFERENCE);
		$class->add('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('/assets/publishit/js/script.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('/assets/message/js/message.js', $class::JAVASCRIPT_REFERENCE);

		$this->CI->load->library('Message');
		
		// keep_flashdata makes an redirect possible. Actually the opposite of learnit.
		$this->CI->session->keep_flashdata('requested_url');

		if ($_POST) {
			$this->handle_post();
		}

		if(isset($_GET['logout'])) {
			$this->CI->user->logout();
			header('Location: /');
		}
	}


	/**
	 * Processes any posted variables and handle them the right way.
	 * 
	 */
	private function handle_post() {
		// Reads with kind op operation is handled.
		$form_id = $this->CI->input->post('form_id');

		// Fetch associated post variables and remove prefix. Any post variables is automatically added to the array.
		$this->replacement_data = $this->CI->input->translate_prefix($form_id);
		$this->translated_data = $this->replacement_data;
		
		switch ($form_id) {
			case 'login_form':
				$this->login_user();
				if ($this->CI->user->is_logged_in && $this->CI->session->flashdata('requested_url')) {
					redirect($this->CI->session->flashdata('requested_url'));
				}
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


	/**
	 * Try to login the user. IF the attempt fails an error message is displayed.
	 * 
	 */
	private function login_user() {
		try {
			$success = $this->CI->user->login($this->translated_data['username'], $this->translated_data['password']);
		} catch(Soapfault $e) {
			$this->CI->message->set_error_message('Oops... it wasn\'t possible to log you in, please try again later');
			$this->data['error_messages'] = $this->CI->message->render();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
			return;
		}
		if (!$success) {
			$this->CI->message->set_error_message('Oops... something seems to be wrong with your username, password combo');
			$this->data['error_messages'] = $this->CI->message->render();
			log_message('error', 'Wrong username or passoword');
		}
	} // login()

	/**
	 * Creates a new account. If the call fails an error message is displayed.
	 * 
	 */
	private function create_account() {
		$client = @new SoapClient ("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
		try {
			// Solves the date time problem by changing the format.	
			$this->translated_data['birthday'] =  date('Y-m-d\TH:i:sP', strtotime($this->translated_data['birthday']));
			$client->RegisterUser(array('user' => $this->translated_data));
		} catch (SoapFault $e){
			$this->CI->message->set_error_message('Oops... it wasn\'t possible to create your account, please try again later');
			$this->data['error_messages'] = $this->CI->message->render();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}
	}

	/**
	 * Render loads a view and either returns it or shows it.
	 * 
	 * @return String Raw html as a view.
	 */
	public function render() {
		return $this->CI->load->view('login', $this->data, true);
	}
}