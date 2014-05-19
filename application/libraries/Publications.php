<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Publications {

	private $CI;

	private $data;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		$this->get_medias_by_user();
		

	}


	public function get_medias_by_user() {
		ini_set("soap.wsdl_cache_enabled", "0");
		$client = new SoapClient ("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
		
		// get the id from the current user to pass as parameter for GetMediaByAuther(id)
		$params = array('id' => $this->CI->user->user_id);
		$test = array('id' => 1);

		try {
			$medias = $client->GetMediaByAuthor($test);

		} catch (SoapFault $e) {
				echo '<pre>';
				var_dump($e->getMessage());
				var_dump($e->detail);
				var_dump($e->faultcode);
				echo '</pre>';
		}
		


		foreach($medias->GetMediaByAuthorResult->media as $media) {


			$this->data['medias'][$media->media_id]['title'] = $media->title;
			$this->data['medias'][$media->media_id]['average rating'] = $media->average_rating;
			$this->data['medias'][$media->media_id]['description'] = $media->description;
			$this->data['medias'][$media->media_id]['date'] = $media->date;
			$this->data['medias'][$media->media_id]['number of downloads'] = $media->number_of_downloads;

		}


		
		//echo '<pre>';
		//var_dump($this->CI->user->user_id);
		//echo '</pre>';


	}



	public function render() {
		return $this->CI->load->view('publications', $this->data, true);
	}
}