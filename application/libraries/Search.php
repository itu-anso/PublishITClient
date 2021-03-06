<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search {

	/**
	 * Array which holds data for the view.
	 * 
	 * @var array
	 */
	private $data;
	
	/**
	 * Holds a reference to the codeigniter framework.
	 * 
	 * @var Object
	 */
	private $CI;

	/**
	 * Init the search module called by the page model.
	 * 
	 * @param  int $module_id The module id
	 */
	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		
		$class->add('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('/assets/publishit/js/script.js', $class::JAVASCRIPT_REFERENCE);

		$class->add('/assets/search/js/search.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('/assets/raty/lib/jquery.raty.min.js', $class::JAVASCRIPT_REFERENCE);

		$class->add('/assets/search/search.css', $class::STYLESHEET_REFERENCE);

		$this->CI->load->library('Message');

		if ($_FILES || $_POST ) {
			$this->handle_post();
		}

		if ($_GET) {
			$this->handle_get();
		}
	}

	/**
	 * Processes any get variables submitted.
	 * 
	 * @return [type] [description]
	 */
	private function handle_get() {
		$form_id = $this->CI->input->get('form_id');
		$this->replacement_data = $this->CI->input->translate_prefix($form_id);
		$this->translated_data = $this->replacement_data;

		switch ($form_id) {
			case 'search_form':
				$this->search_media();
				break;
			default:
				break;
		}
	}

	/**
	 * Processes any post variables submitted.
	 * 
	 * @return [type] [description]
	 */
	private function handle_post() {
		$form_id = $this->CI->input->post('form_id');
		$this->replacement_data = $this->CI->input->translate_prefix($form_id);
		$this->translated_data = $this->replacement_data;

		switch ($form_id) {
			case 'upload_file_form':
				$this->upload_file();
				if(!$this->CI->message->has_error()) {
					redirect('/');
				}
				break;
			case 'download_form':
				$this->download();
				break;
			default:
				break;
		}
	}

	/**
	 * Download a media.
	 * 
	 */
	private function download() {
		try {
			$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
			$params = array('id' => $this->translated_data['media_id']);
			//$retval = $client->Test(null);
			
			$result = $client->DownloadMedia($params);

			header('Content-type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $this->translated_data['media_title'] . '.pdf"');

			echo ($result->DownloadMediaResult);
		} catch(SoapFault $e) {
			$this->CI->message->set_error_message('Oops... it wasn\'t possible to fetch your file, please try again later');
			$this->data['error_messages'] = $this->CI->message->render();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}
		
	}

	/**
	 * Search and return medias.
	 * 
	 */
	private function search_media() {
		try {
			$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl", array('cache_wsdl' => WSDL_CACHE_NONE));

			$params = array('title' => $this->translated_data['search_string'], 'organizationId' => 1);
			$retval = $client->SearchMedia($params);

			if(isset($retval->SearchMediaResult->MediaDTO->title)) {
				$media_list[0] = $retval->SearchMediaResult->MediaDTO;
			} else {
				$media_list = $retval->SearchMediaResult->MediaDTO;
			}

			$this->parse_medias($media_list);
		} catch (SoapFault $e) {
			$this->CI->message->set_error_message('Oops... it wasn\'t possible to fetch your results, please try again later');
			$this->data['error_messages'] = $this->CI->message->render();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}
	}

	/**
	 * [parse_medias description]
	 * 
	 * @param  stdObject $medias The object returned from the service.
	 */
	private function parse_medias ($medias) {
		try {
			$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl", array('cache_wsdl' => WSDL_CACHE_NONE));
		} catch (SoapFault $e) {
			$this->CI->message->set_error_message('Oops... it wasn\'t possible to fetch your results, please try again later');
			$this->data['error_messages'] = $this->CI->message->render();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}
		
		foreach ($medias as $media ) {
			$this->data['medias'][$media->media_id]['title'] = $media->title;
			$this->data['medias'][$media->media_id]['user_id'] = $media->user_id;
			$this->data['medias'][$media->media_id]['format_id'] = $media->format_id;
			$this->data['medias'][$media->media_id]['average_rating'] = $media->average_rating;
			$this->data['medias'][$media->media_id]['date'] = $media->date;
			$this->data['medias'][$media->media_id]['description'] = $media->description;
			$this->data['medias'][$media->media_id]['location'] = $media->location;
			$this->data['medias'][$media->media_id]['number_of_downloads'] = $media->number_of_downloads;
			$this->data['medias'][$media->media_id]['author'] = $this->get_author($media->user_id);

			$this->data['rating'] = $client->GetRating(array('mediaId' => $media->media_id, 'userId' => $media->user_id));
		}
	}

	/**
	 * Get author by his id.
	 * @param  int $id The user id.
	 */
	private function get_author($id) {
		try {
			$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
			$params = array('id' => $id);
			$retval = $client->GetUserById($params);
			return $retval->GetUserByIdResult->name;
		} catch (SoapFault $e) {
			$this->CI->message->set_error_message('Oops... it wasn\'t possible to fetch your results, please try again later');
			$this->data['error_messages'] = $this->CI->message->render();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}
	}

	/**
	 * Uploads a file to the service.
	 * 
	 */
	private function upload_file() {
		if ($_FILES) {
			
			$temp = explode(".", ($_FILES["upload_file_form_upload_file"]["name"]));
			$extension = end($temp);

			if ($extension != 'pdf') {
				$this->CI->message->set_error_message('Sory... only pdf files are allowed at the moment');
				$this->data['error_messages'] = $this->CI->message->render();
				log_message('info', 'Wrong file format');
			}

			$file = fopen($_FILES['upload_file_form_upload_file']['tmp_name'], 'r');
			$contents = fread($file, filesize($_FILES['upload_file_form_upload_file']['tmp_name']));

			fclose($file);
			$headers[] = new SoapHeader('http://tempuri.org/', 'Title', $this->translated_data['title']);
			$headers[] = new SoapHeader('http://tempuri.org/', 'FileName', $_FILES["upload_file_form_upload_file"]["name"]);
			$headers[] = new SoapHeader('http://tempuri.org/', 'UserId', $this->CI->user->user_id);
			$headers[] = new SoapHeader('http://tempuri.org/', 'Status', (isset($this->translated_data['status']) ? 'published' : 'private'));
			$headers[] = new SoapHeader('http://tempuri.org/', 'Description', $this->translated_data['title']);

			$params =  array(
					'FileStream' => $contents
			);

			try {
				$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl", array('trace' => true, 'cache_wsdl' => WSDL_CACHE_NONE));
				$client->__setSoapHeaders($headers);
				$client->UploadMedia($params);
			} catch (SoapFault $e){
				$this->CI->message->set_error_message('Ooops... Something went wrong when trying to upload your document, please try again later');
				$this->data['error_messages'] = $this->CI->message->render();
				log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
			}
		}
	}

	/**
	 * Is used to call ajax functions without reaching any other modules.
	 * 
	 */
	public function ajax() {
		try {
				$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl", array('trace' => true, 'cache_wsdl' => WSDL_CACHE_NONE));
				$params = array('rating' => $this->CI->input->post('rating'), 'mediaId' => $this->CI->input->post('media_id'), 'userId' => $this->CI->user->user_id);
				$client->PostRating($params);
		} catch (SoapFault $e){
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}
	}

	/**
	 * Renders the search page.
	 * 
	 */
	public function render() {
		return $this->CI->load->view('search', $this->data, true);
	}
}