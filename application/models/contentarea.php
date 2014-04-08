<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContentArea extends CI_Model {

	protected $content_areas = array();

	private $index = 0;

	/**
	 * Add a content area to a template.
	 *
	 * @param string $template Which template to add the content area.
	 * @param string $area_name A name for the area.
	 */
	public function add_content_area($template) {
			$this->content_areas[$template][$this->index] = true;
			$this->index ++;
	} // add_content_area()

	/**
	 * Return an area with the content areas for the selected template.
	 * @param  string The template.
	 * @return array Array containing content areas.
	 */
	public function get_content_areas($template) {
		return $this->content_areas[$template];
	} // get_content_areas()
}