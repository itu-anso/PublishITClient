<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search {

	private $CI;

	private $data;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;
		$this->CI->load->library('Message');

		$class->add('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('/assets/publishit/js/script.js', $class::JAVASCRIPT_REFERENCE);

		
		//var_dump($_FILES);
		if ($_FILES || $_POST ) {
			$this->handle_post();
		}

		if ($_GET) {
			$this->handle_get();
		}
	}

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

	private function handle_post() {
		$form_id = $this->CI->input->post('form_id');
		$this->replacement_data = $this->CI->input->translate_prefix($form_id);
		$this->translated_data = $this->replacement_data;

		switch ($form_id) {
			case 'upload_file_form':
				$this->upload_file();
				break;
			case 'download_form':
				$this->download();
				break;
			default:
				break;
		}
	}

	private function download() {
		try {
			$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
			$params = array('id' => $this->translated_data['media_id']);
			//$retval = $client->Test(null);
			
			$result = $client->DownloadMedia($params);
			
			header('Content-type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $this->translated_data['media_id'] . '.pdf"');

			echo ($result->DownloadMediaResult);
		} catch(SoapFault $e) {
			$this->CI->message->set_error_message('Uuups... it wasn\'t possible to fetch your file, please try again later');
			$this->data['error_messages'] = $this->CI->message->get_rendered_error_messages();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}
		
	}

	private function search_media() {
		try {
			$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");

			$params = array('title' => $this->translated_data['search_string']);
			$retval = $client->searchMedia($params);
			$this->parser_medias($retval->SearchMediaResult);
		} catch (SoapFault $e) {
			$this->CI->message->set_error_message('Uuups... it wasn\'t possible to fetch your results, please try again later');
			$this->data['error_messages'] = $this->CI->message->get_rendered_error_messages();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}
	}

	private function parser_medias ($medias) {
		foreach ($medias->media as $media ) {
			$this->data['medias'][$media->media_id]['title'] = $media->title;
			$this->data['medias'][$media->media_id]['user_id'] = $media->user_id;
			$this->data['medias'][$media->media_id]['format_id'] = $media->format_id;
			$this->data['medias'][$media->media_id]['average_rating'] = $media->average_rating;
			$this->data['medias'][$media->media_id]['date'] = $media->date;
			$this->data['medias'][$media->media_id]['description'] = $media->description;
			$this->data['medias'][$media->media_id]['location'] = $media->location;
			$this->data['medias'][$media->media_id]['number_of_downloads'] = $media->number_of_downloads;
			$this->data['medias'][$media->media_id]['author'] = $this->get_author($media->user_id);
		}
	}

	private function get_author($id) {
		try {
			$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
			$params = array('id' => $id);
			$retval = $client->GetUserById($params);
			return $retval->GetUserByIdResult->name;
		} catch (SoapFault $e) {
			$this->CI->message->set_error_message('Uuups... it wasn\'t possible to fetch your results, please try again later');
			$this->data['error_messages'] = $this->CI->message->get_rendered_error_messages();
			log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
		}

	}

	private function upload_file() {
		if ($_FILES) {
			$temp = explode(".", $_FILES["upload_file_form_upload_file"]["name"]);
			$extension = end($temp);

			if ($extension != 'pdf') {
				$this->CI->message->set_error_message('Sory... only pdf files are allowed at the moment');
				$this->data['error_messages'] = $this->CI->message->get_rendered_error_messages();
				log_message('info', 'Wrong file format');
			}

			$file = fopen($_FILES['upload_file_form_upload_file']['tmp_name'], 'r');
			$contents = fread($file, filesize($_FILES['upload_file_form_upload_file']['tmp_name']));

			fclose($file);
			$headers[] = new SoapHeader('http://tempuri.org/', 'Title', $this->translated_data['title']);
			$headers[] = new SoapHeader('http://tempuri.org/', 'FileName', $_FILES["upload_file_form_upload_file"]["name"]);
			$headers[] = new SoapHeader('http://tempuri.org/', 'UserId', $this->CI->user->user_id);
			$headers[] = new SoapHeader('http://tempuri.org/', 'Status', (isset($this->translated_data['status']) ? 'published' : 'private'));
			$headers[] = new SoapHeader('http://tempuri.org/', 'Description', 'published');

			$params =  array(
					'FileStream' => $contents
			);

			try {
				$client = @new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl", array('trace' => true, 'cache_wsdl' => WSDL_CACHE_NONE));
				$client->__setSoapHeaders($headers);
				$client->UploadMedia($params);
			} catch (SoapFault $e){
				$this->CI->message->set_error_message('Uuups... Something went wrong when trying to upload your document, please try again later');
				$this->data['error_messages'] = $this->CI->message->get_rendered_error_messages();
				log_message('error', 'SoapFault ["fault"] : ' . $e->faultcode . ' [faultstring] : ' . $e->faultstring);
			}
		}
	}

	public function render() {
		return $this->CI->load->view('search', $this->data, true);
	}

}