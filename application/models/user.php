<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model{

	public $user_id;
	public $name;
	public $email;
	public $is_logged_in = false;
	public $is_admin = false;

	public function __construct() {
		if ($this->session->userdata('name')) {
			$this->user_id = $this->session->userdata('user_id');
			$this->name = $this->session->userdata('name');
			$this->email = $this->session->userdata('email');
			$this->is_logged_in = true;
			$this->is_admin = $this->session->userdata('is_admin');
		}
	} // __construct()

	/**
	* Log a usre in to the system.
	*
	*/
	public function login($email = null, $password = null) {
		$client = new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
		$user_info = $client->signIn(array('username' => $email, 'password' => $password));
		

		//if ($result->num_rows() > 0) {
			//$row = $result->row();
			$this->user_id = $user_info->SignInResult->user_id;
			$this->name = $user_info->SignInResult->name;
			$this->email = $user_info->SignInResult->email;
			$this->is_logged_in = true;

			$roles = $user_info->SignInResult->roles->RoleDTO;
			foreach ($roles as $object) {
				if ($object->Title == 'admin') {
					$this->is_admin = true;
				}
			}

			$user_session_data = array(
				'user_id' => $user_info->SignInResult->user_id,
				'name' => $user_info->SignInResult->name,
				'email' => $user_info->SignInResult->email,
				'is_logged_in' => true,
				'is_admin' => $this->is_admin
			);
			$this->session->set_userdata($user_session_data);
		//}

 		if ($this->is_logged_in) {
 			return true;
 		} else {
 			return false;
 		}
	} // login()

	/**
	 * Destroy the current user session.
	 */
	public function logout() {
		$this->session->sess_destroy();
		$this->is_logged_in = false;
	} // logout()

	/**
	 * Updates the users password. 
	 * @param  [array] $data [description]
	 */
	public function new_password($data) {
		if ($data['password'] == $data['repeat_password']) {
			$query = $this->db->query("SELECT salt FROM user WHERE user_id = ?", $this->user->user_id);
			$row = $query->row();
			$salt = $row->salt;
			$new_password = $this->encode_password($data['password'], $salt);
			$query = "
				UPDATE
					user
				SET
					password = ?
				WHERE
					user_id = ?";
			$this->db->query($query, array($new_password, $this->user->user_id));
		}
	} // new_password()

	/**
	 *	Creates a new user.
	 */
	public function new_user($user_data) {
		$this->load->helper('email_helper');
		$random_string = $this->generate_random_string(6);
		$salt = $this->generate_random_string(32);
		$password = $this->encode_password($random_string, $salt);
		$query = "
			INSERT INTO
				user (name, surname, password, address, zip, city, phone, email, salt, role)
			VALUES (?, ?, ?, '', 0, '', null, ?, ?, ?)";
		$this->db->query($query, array(
			$user_data['name'],
			$user_data['surname'],
			$password,
			$user_data['email'],
			$salt,
			$user_data['role']
		));
		send_email($user_data['email'], 'Ambar.dk', 'Vi sender hermed dit kodeord ' . $random_string);
	} // new_user()

	/**
	 * Random string generater, used to create new passwords.
	 * @param  integer $length [description]
	 * @return [type]          [description]
	 */
	private function generate_random_string($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/_-';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	} // generate_random_string()

	/**
	 * Encodes the password and the salt.
	 * @param unknown_type $password
	 */
	private function encode_password($password, $salt) {
		return hash('sha512', $salt . $password . $this->config->item('encryption_key'));
	} // encode_password()
} // Users
