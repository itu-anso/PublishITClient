<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HeaderQueue extends CI_Model {

	/**
	 * The actual queue. This should be flushed in the default view.
	 *
	 * @var array
	 */
	private $header_queue = array();

	const JAVASCRIPT_REFERENCE = 0;
	const STYLESHEET_REFERENCE = 1;

	/**
	 * Queue items to be inserted into the header.
	 * This regards js, css etc..
	 *
	 * @param string $url
	 * @param constant $type
	 * @param array $other_param
	 */
	public function add($url, $type, $other_param=array()) {
		switch ($type) {
			case self::JAVASCRIPT_REFERENCE :
				$retval = '<script type="text/javascript" src="' . $url . '"></script>';
				array_push($this->header_queue, $retval);
				break;
			case self::STYLESHEET_REFERENCE :
				$retval = '<link rel="stylesheet" href="' . $url . '" type="text/css">';
				array_push($this->header_queue, $retval);
				break;
		}
	} // add()

	/**
	 * Ad a meta tag to the header queue.
	 *
	 * @param string $name
	 * @param string $content
	 * @param string $charset
	 * @param string $http-equiv
	 */
	public function add_meta_tag($name = '', $content = '', $charset = '', $http_equiv = '') {
		$retval = '<meta ';
		if ($name != '') {
			$retval .= 'name=' . $name . ' ';
		}
		if ($content != '') {
			$retval .= 'content=' . $content . ' ';
		}
		if ($charset != '') {
			$retval .= 'charset=' . $charset . ' ';
		}
		if ($http_equiv != '') {
			$retval .= 'http-equiv=' . $http_equiv . ' ';
		}
		$retval .= '>';
		array_push($this->header_queue, $retval);
	} // add_meta_tag()

	/**
	 * Used to flush the header queue array.
	 *
	 */
	public function flush_header_queue() {
		foreach ($this->header_queue as $header_item) {
			echo $header_item;
		} // foreach
	} // flush_header_queue()
}