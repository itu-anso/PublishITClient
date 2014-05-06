<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search {

	private $CI;

	private $data;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		$class->add('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('/assets/publishit/js/script.js', $class::JAVASCRIPT_REFERENCE);

	}

	public function render() {

		//$client = new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
		//$params =  array('id' => 1 );
		//var_dump($client->__getFunctions());

		return $this->CI->load->view('search', $this->data, true);
	}

}