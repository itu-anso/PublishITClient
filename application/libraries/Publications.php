<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Publications {

	private $CI;

	private $data;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		
		if ($this->CI->user->is_logged_in){
			$this->get_medias_by_user();	
		}
		
	}


	public function get_medias_by_user() {
		// create a new client to use the service. The wsdl file contains information about the service (method names ect.)
		$client = new SoapClient ("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
		
		// get the id from the current user to pass as parameter for GetMediaByAuther(id)
		$params = array('id' => $this->CI->user->user_id);

		try {
			// get the medias from this user
			$medias = $client->GetMediaByAuthor($params);
		} catch (SoapFault $e) {
				echo '<pre>';
				var_dump($e->getMessage());
				var_dump($e->detail);
				var_dump($e->faultcode);
				echo '</pre>';
		}		

		if(isset($medias->GetMediaByAuthorResult->media->title)) {
			$media_list[0] = $medias->GetMediaByAuthorResult->media;

		} else {

			$media_list = $medias->GetMediaByAuthorResult->media;
		}
		foreach($media_list as $media) {

			$this->data['medias'][$media->media_id]['title'] = $media->title;
			$this->data['medias'][$media->media_id]['average rating'] = $media->average_rating;
			$this->data['medias'][$media->media_id]['description'] = $media->description;
			$this->data['medias'][$media->media_id]['date'] = $media->date;
			$this->data['medias'][$media->media_id]['number of downloads'] = $media->number_of_downloads;

		}

	}


	public function render() {
		return $this->CI->load->view('publications', $this->data, true);
	}
}