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
		
		if ($_GET) {
			$this->handle_get();
		}
	}

	public function get_medias_by_user() {

		try {
			// create a new client to use the service. The wsdl file contains information about the service (method names ect.)
			$client = @new SoapClient ("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl", array('cache_wsdl' => WSDL_CACHE_NONE));
			
			// get the id from the current user to pass as parameter for GetMediaByAuther(id)
			$params = array('userId' => $this->CI->user->user_id);

			// get the medias from this user
			$medias = $client->GetMediaByAuthorId($params);

			// This is to see if the result is empty
			$temp = (array)$medias->GetMediaByAuthorIdResult;
			
			if (empty($temp)) {
				return;
			}
		} catch (SoapFault $e) {
			$this->CI->message->set_error_message('Uuups..  it wasn\'t possible to fetch your documents, please try again later');
			$this->data['error_messages'] = $this->CI->message->get_rendered_error_messages();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
			return;
		}

		if(isset($medias->GetMediaByAuthorIdResult->MediaDTO->title)) {
			$media_list[0] = $medias->GetMediaByAuthorIdResult->MediaDTO;
		} else {
			$media_list = $medias->GetMediaByAuthorIdResult->MediaDTO;
		}


		foreach($media_list as $media) {
			

			$this->data['medias'][$media->media_id]['title'] = $media->title;
			$this->data['medias'][$media->media_id]['average_rating'] = $media->average_rating;
			$this->data['medias'][$media->media_id]['description'] = $media->description;
			$this->data['medias'][$media->media_id]['date'] = $media->date;
			$this->data['medias'][$media->media_id]['number_of_downloads'] = $media->number_of_downloads;
			$this->data['medias'][$media->media_id]['media_id'] = $media->media_id;

		}
	}

	private function handle_get() {
		$form_id = $this->CI->input->get('form_id');
		$this->replacement_data = $this->CI->input->translate_prefix($form_id);
		$this->translated_data = $this->replacement_data;
		switch ($form_id) {
			case 'read':
				$this->show_document();
				break;
			default:
				break;
		}
	}

	private function show_document(){
		try {
			$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
			$params = array('id' => $this->translated_data['media_id']);

			$result = $client->DownloadMedia($params);
			
			header('Content-type: application/pdf');
			// It will be called downloaded.pdf
			header('Content-Disposition: inline; filename="' . $this->translated_data['media_id'] . '.pdf"');

			echo ($result->DownloadMediaResult);
		} catch (SoapFault $e) {
			$this->CI->message->set_error_message('Uuups..  it wasn\'t possible to fetch your documents, please try again later');
			$this->data['error_messages'] = $this->CI->message->get_rendered_error_messages();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}
	}

	public function render() {
		return $this->CI->load->view('publications', $this->data, true);
	}
}