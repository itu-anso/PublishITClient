<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sitemap {

	private $CI;

	private $data;

	private $replacement_data;
	private $translated_data;

	public function init() {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		$this->CI->headerqueue->add('/assets/SiteMap/SiteMap.css', $class::STYLESHEET_REFERENCE);
		$this->CI->headerqueue->add('//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', $class::STYLESHEET_REFERENCE);
		$this->CI->headerqueue->add('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js', $class::JAVASCRIPT_REFERENCE);
		$this->CI->headerqueue->add('/assets/SiteMap/SiteMap.js', $class::JAVASCRIPT_REFERENCE);
		$this->CI->headerqueue->add('//code.jquery.com/ui/1.10.3/jquery-ui.js', $class::JAVASCRIPT_REFERENCE);
		$this->get_site_map();

		if ($_POST) {
			$this->handle_post();
		}

		//if ($_POST) $this->handle_get();
		//var_dump($this->data);
	}

	private function handle_post() {
		$form_id = $this->CI->input->post('form_id');
		$this->replacement_data = $this->CI->input->translate_prefix($form_id);
		$this->translated_data = $this->replacement_data;

		switch ($form_id) {
			case 'new_page':
				$this->new_page();
				break;
			default:
				break;
		}
	} // handle_post()

	private function handle_get() {

	} // handle_get()

	private function new_page() {
		$query = "
			INSERT INTO page(parent_page_id, page_title, page_path, template, privileges)
			VALUES (
				1,
				'new page',
				'/new-page',
				'',
				1)";
		$this->CI->db->query($query);
		header('location: /admin');
	} // new_page()

	/**
	 * Get the site map.
	 *
	 * @return string The sitemap view.
	 */
	private function get_site_map() {
		$query = "
			SELECT 
				p.page_id,
				p.page_title AS parent_page_title,
				p2.page_id AS child_page_id,
				p2.page_title AS child_page_title
			FROM
				page p
				LEFT JOIN page p2 ON(p.page_id = p2.parent_page_id)
			WHERE
				p.parent_page_id = -1
			ORDER BY p.page_id, p2.page_id";
		$result = $this->CI->db->query($query);
		$result = $result->result_array();
		$this->data['sitemap'] = $result;
	} // get_site_map()

	private function show_settings() {
		$setting_page = new Page();
		$setting_page->init_page($this->translated_data['page_id']);
		$data['setting'] = $setting_page->get_settings();
		$data['module_settings'] = $setting_page->get_module_settings();
		$this->CI->load->view('SiteMap/settingsForm', $data);
	}

	/**
	 * Update the settings for a page.
	 */
	private function update_settings() {
		$this->handle_post();
		$query = "
			UPDATE
				page
			SET
				parent_page_id = ?,
				page_title = ?,
				page_path = ?,
				template = ?,
				privileges = ?
			WHERE
				page_id = ?";
		$this->CI->db->query($query, array(
			$this->translated_data['parent_page_id'],
			$this->translated_data['page_title'], 
			$this->translated_data['page_path'],
			$this->translated_data['template'],
			$this->translated_data['privileges'],
			$this->translated_data['page_id']));
	} // update_settings()

	public function ajax() {
		switch ($this->CI->input->post('action')) {
			case 'show_settings':
				$this->show_settings();
				break;
			case 'update_settings':
				$this->update_settings();
				break;
			
			default:
				break;
		}
	} // ajax()

	public function render() {
		return $this->CI->load->view('sitemap/sitemap', $this->data, true);

	}

}
