<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends CI_CONTROLLER {

	public function init($module_id=null) {
		$class = $this->headerqueue;
		$this->headerqueue->add('/assets/AdminConsole/AdminConsole.css', $class::STYLESHEET_REFERENCE);
	}

	public function render() {
		return $this->load->view('adminconsole/adminconsole', '', true);

	}

}
