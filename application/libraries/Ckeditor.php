<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ckeditor {

	private $CI;

	private $data;

	private $module_id;

	public function init($id) {
		$this->module_id = $id;
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		$this->CI->headerqueue->add("//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", $class::JAVASCRIPT_REFERENCE);
		$this->CI->headerqueue->add('/assets/ckeditor/ckeditor.js', $class::JAVASCRIPT_REFERENCE);
		$this->CI->headerqueue->add('/assets/ambardk/js/default.js', $class::JAVASCRIPT_REFERENCE);
		$this->data['ckeditor'] = $this->get_data();
		$this->data['ckeditor_id'] = $this->get_editor_id();
	}

	public function index() {
		switch ($this->input->post('action')) {
			case 'save_data':
				$this->save_data();
				break;
			case 'get_data':
				$this->get_data();
				break;
			default:
				break;
		}
	}

	/**
	*
	*
	*/
	public function get_editor_id() {
		$query = "
			SELECT
				ckeditor_id
			FROM
				ckeditor
			WHERE
				module_id = ?";
		$result = $this->CI->db->query($query, array($this->module_id));

		if ($result->num_rows() > 0) {
			$row = $result->row();
			return $row->ckeditor_id;
		} else {
			return 0;
		}
	} // get_data()

	/**
	*
	*
	*/
	public function get_data() {
		$query = "
			SELECT
				ckeditor_id,
				content
			FROM
				ckeditor
			WHERE
				module_id = ?";
		$result = $this->CI->db->query($query, array($this->module_id));

		if ($result->num_rows() > 0) {
			$row = $result->row();
			return $row->content;
		} else {
			return '<p>Indsæt tekst her!<p/>';
		}
	} // get_data()

	/**
	*
	*
	*/
	public function save_data() {
		$query = "
			INSERT INTO ckeditor (
				ckeditor_id,
				module_id,
				content)
			VALUES (
				?,
				?,
				?)
			ON DUPLICATE KEY UPDATE
				content = ?";
		$this->CI->db->query($query, array(
			$this->CI->input->post('ckeditor_id'),
			$this->CI->input->post('module_id'),
			$this->CI->input->post('data'),
			$this->CI->input->post('data')));
	} // save_data()

	public function ajax() {
		$this->save_data();
	}

	public function render() {
		$this->data['module_id'] = $this->module_id;
		return $this->CI->load->view('ckeditor', $this->data, true);
	}
}
