<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Breadcrumb extends CI_Model {
	private $bread = '';
	private $crumbs = array();
	private $href_param;
	private $seperator;
	private $home_text;
	private $home_link;

	/**
	 * [Breadcrumb description]
	 * @param string $seperator  [description]
	 * @param [type] $href_param [description]
	 * @param string $home_link  [description]
	 * @param string $home_text  [description]
	 */
	public function Breadcrumb($seperator="&nbsp;&gt;&nbsp;",$href_param=NULL,$home_link='/',$home_text = "Bakkely-grf"){
		$this->href_param = $href_param;
		$this->seperator = $seperator;
		$this->home_text = $home_text;
		$this->home_link = $home_link;
		$this->crumbs[] = array('crumb'=>$this->home_text,'link'=>$this->home_link);
		if (uri_string() != 'ckeditor' && uri_string() != '') {
			if (uri_string() == 'vedtaegter') {
				$this->addCrumb('Vedtægter');
			} else {
				$this->addCrumb(ucfirst(uri_string()));
			}
		}
	}

	/**
	 * [addCrumb description]
	 * @param [type] $this_crumb [description]
	 * @param [type] $this_link  [description]
	 */
	public function addCrumb($this_crumb,$this_link = NULL){
		$in_crumbs = false;
		// first check that we haven't already got this link in the breadcrumb list.
		foreach($this->crumbs as $crumb){
			if($crumb['crumb'] == $this_crumb ){
				$in_crumbs = true;
			}
			if($crumb['link'] == $this_link &&  $this_link != ''){
				$in_crumbs = true;
			}
		}
		if($in_crumbs == false){
			$this->crumbs[] = array('crumb'=>$this_crumb,'link'=>$this_link);
		}
	}

	/**
	 * [makeBread description]
	 * @return [type] [description]
	 */
	public function makeBread(){
		$sandwich = $this->crumbs;
		$slices = array();
		foreach($sandwich as $slice){
			if (isset($slice['link']) && $slice['link'] != '') {
				$slices[] = '<a href="' . $slice['link'] . '" '.$this->href_param.'>' . $slice['crumb'] . '</a>';
			} else {
				$slices[] = $slice['crumb'];
			}
		}
		$this->bread = join($this->seperator, $slices);
		return $this->bread;
	}
}