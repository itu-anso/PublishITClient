<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search {

	private $CI;

	private $data;

	public function init($module_id=null) {
		$this->CI =& get_instance();
		$class = $this->CI->headerqueue;

		$class->add('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js', $class::JAVASCRIPT_REFERENCE);
		$class->add('/assets/publishit/js/script.js', $class::JAVASCRIPT_REFERENCE);
		//var_dump($_FILES);
		if ($_FILES || $_GET) {
			$this->handle_post();
		}
	}

	private function handle_post() {
		$form_id = $this->CI->input->get_post('form_id');
		$this->replacement_data = $this->CI->input->translate_prefix($form_id);
		$this->translated_data = $this->replacement_data;

		switch ($form_id) {
			case 'upload_file_form':
				$this->upload_file();
				//redirect('/');
				break;
			case 'search_form':
				$this->search_media();
				break;
			case 'download_form':
				$this->download();
				break;
			default:
				break;
		}
	}

	private function download() {
		$client = new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl", array('trace' => true, 'cache_wsdl' => WSDL_CACHE_NONE));
		$params = array('id' => $this->translated_data['media_id']);
		//$retval = $client->Test(null);
		
		$result = $client->DownloadMedia($params);
		
		header('Content-type: application/pdf');
		// It will be called downloaded.pdf
		header('Content-Disposition: attachment; filename="downloaded.pdf"');

		// The PDF source is in original.pdf
		//readfile('original.pdf');
		echo ($result->DownloadMediaResult);
		//var_dump($client->__getLastResponse());
		
	}

	private function search_media() {
		//var_dump($this->translated_data);

		$client = new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
		$params = array('title' => $this->translated_data['search_string']);
		$retval = $client->searchMedia($params);
		$this->parser_medias($retval->SearchMediaResult);

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
		$client = new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
		$params = array('id' => $id);
		$retval = $client->GetUserById($params);
		return $retval->GetUserByIdResult->name;
	}

	private function upload_file() {
		if ($_FILES) {
			$temp = explode(".", $_FILES["upload_file_form_upload_file"]["name"]);
			$extension = end($temp);
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
			
			$client = new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl", array('trace' => true, 'cache_wsdl' => WSDL_CACHE_NONE));
			$client->__setSoapHeaders($headers);
			try {
				$client->UploadMedia($params);
			} catch (SoapFault $e){
				echo '<pre>';
				var_dump($e);
				echo '</pre>';
			}
		}
	}

	public function render() {

		$client = new SoapClient("http://rentit.itu.dk/RentIt09/PublishITService.svc?wsdl");
		$params =  array('id' => 1 );
		//var_dump($client->__getFunctions());

		return $this->CI->load->view('search', $this->data, true);
	}

}