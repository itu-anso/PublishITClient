<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ckeditor extends CI_Model {

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
	public function get_data() {
		$query = "
			SELECT
				content
			FROM
				ckeditor
			WHERE
				ckeditor_id = ?";
		$result = $this->db->query($query, array($this->input->post('ckeditor_id')));

		if ($result->num_rows() > 0) {
			$row = $result->row();
			echo $row->content;
		} else {
			echo '<p>Indsæt tekst her!<p/>';
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
				content)
			VALUES (
				?,
				?)
			ON DUPLICATE KEY UPDATE
				content = ?";
		$this->db->query($query, array(
			$this->input->post('ckeditor_id'), 
			$this->input->post('data'),
			$this->input->post('data')));
	} // save_data()
}
