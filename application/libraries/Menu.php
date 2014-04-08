<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu {

	private $CI;

	private $data;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;

		$this->CI->headerqueue->add('/assets/Menu/Menu.css', $class::STYLESHEET_REFERENCE);

		$this->load_menu();
	}

	private function load_menu() {
		$query = "
			SELECT
				p.page_title,
				p.page_path
			FROM
				page p
				LEFT JOIN page p2 ON(p.page_id = p2.parent_page_id)
			WHERE
				p.show_in_menu = 'true'
			AND
				p.parent_page_id = -1
			ORDER BY p.page_id, p2.page_id";
		$result = $this->CI->db->query($query);
		$result = $result->result_array();
		$this->data['menu'] = $result;
	} // load_menu()

	public function render() {
		return $this->CI->load->view('menu', $this->data, true);

	}

}
