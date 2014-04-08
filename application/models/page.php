<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page extends CI_Model {

	private $page_id;

	private $parent_page_id;

	private $page_title;

	private $page_path;

	public $template;

	public $privileges;

	/**
	 * [init_page description]
	 * @return [type] [description]
	 */
	public function init_page($page_id) {
		$this->page_id = $page_id;

		$query = "
			SELECT
				parent_page_id,
				page_title,
				page_path,
				template,
				privileges
			FROM
				page
			WHERE
				page_id = ?";
		$query = $this->db->query($query, array($this->page_id));
		foreach ($query->result() as $row) {
			$this->parent_page_id = $row->parent_page_id;
			$this->page_title = $row->page_title;
			$this->page_path = $row->page_path;
			$this->template = $row->template;
			$this->privileges = $row->privileges;
		}
	} // init_page()

	/**
	 * Checks the db to see if the requested page exists in
	 * the system.
	 * Returns info about the page.
	 *
	 * @param  [string] $page_title [requested page]
	 * @return [array][page info]
	 */
	public function get_page_info($page_title) {
		$query = "
			SELECT
				page_id,
				parent_page_id,
				page_title,
				page_path,
				template,
				privileges
			FROM
				page
			WHERE
				page_title = '" . $this->db->escape_like_str($page_title) . "'";
		$query = $this->db->query($query);
		foreach ($query->result() as $row) {
			$retval['page_id'] = $row->page_id;
			$retval['parent_page_id'] = $row->parent_page_id;
			$retval['page_title'] = $row->page_title;
			$retval['page_path'] = $row->page_path;
			$retval['template'] = $row->template;
			$retval['privileges'] = $row->privileges;
		}
		return $retval;
	} // get_page_info()

	/**
	 * Returns the modules with attached settings.
	 * 
	 */
	public function get_module_settings() {
		$query = "
			SELECT
				module_id,
				class_name,
				sort_order,
				content_area
			FROM
				module
			WHERE
				module_id = ?";
		$result = $this->db->query($query, array($this->page_id));
		if ($result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$retval[$row->module_id] = array(
					'module_id' => $row->module_id,
					'class_name' => $row->class_name,
					'sort_order' => $row->sort_order,
					'content_area' => $row->content_area);
			}
			return $retval;
		}
	} // get_module_settings()

	/**
	 * Loads a page with modules etc.
	 *
	 * @param  integer $page_id Which page to load.
	 */
	public function load_page(&$data) {
		$query = "
			SELECT
				module_id,
				class_name,
				content_area
			FROM
				page
				INNER JOIN module using(page_id)
			WHERE
				page_id = ?
			ORDER BY sort_order ASC";
		$result = $this->db->query($query, array($this->page_id));

		if ($result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$class = strtolower($row->class_name);
				$this->load->library($class);
				$this->$class->init($row->module_id);

				if (isset($data[$row->content_area]) && !$this->input->post('ajax')) {
					$data[$row->content_area] .=  $this->$class->render();
				} else if ($this->input->post('ajax')) {
					method_exists($this->$class, 'ajax') ? $this->$class->ajax() : '';
				} else {
					$data[$row->content_area] =  $this->$class->render();
				}
			}
		}
	} // load_page()

	public function get_settings() {
		$retval['page_id'] = $this->page_id;
		$retval['parent_page_id'] = $this->parent_page_id;
		$retval['page_title'] = $this->page_title;
		$retval['page_path'] = $this->page_path;
		$retval['template'] = $this->template;
		$retval['privileges'] = $this->privileges;
		return $retval;
	} // get_settings()
}