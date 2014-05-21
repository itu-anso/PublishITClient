<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Main controller which processes every request on the server.
 * 
 */
class Pages extends CI_Controller {

	/**
	 *	The index function is called by default and inits the requested page
	 *	
	 */
	public function index() {

		// Initializing the main content variable
		$this->data['main_content'] = '';
		$request = $this->uri->segment(1);
		
		// Does the requested page exist?
		$page_id = $this->get_page_id("/" . $request);
		$this->page->init_page($page_id);
		$page_settings = $this->page->get_settings();

		if (!empty($page_id)) {
			$this->page->load_page($this->data);
		} else {
			show_404();
		}

		if (!empty($page_id) && !$this->input->post('ajax') && ($this->page->privileges == 1 || $this->user->is_logged_in)) {
			$template = strtolower($this->page->template);
			if (!empty($template)) {
				$this->load->view('Templates/' . $template, $this->data);
			}
		} else if ($this->page->privileges == 2 && !$this->user->is_logged_in) {
			$this->session->set_flashdata('requested_url', $_SERVER["REQUEST_URI"]);
			redirect("/login");
		}
	}

	/**
	 * Checks the db to see if the requested page exists in
	 * the system.
	 * Returns info about the page.
	 *
	 * @param  [string] $page_title [requested page]
	 * @return [array][page info]
	 */
	public function get_page_id($page_title) {
		$query = "
			SELECT
				page_id
			FROM
				page
			WHERE
				page_path = '" . $this->db->escape_like_str($page_title) . "'";
		$query = $this->db->query($query);
		$result = $query->row();
		return (!empty($result->page_id) ? $result->page_id: '');
	} // get_page_info()
}