<?php

class PhotoGalleryHolder extends Page {

	private static $description = "Container for individual Photo Gallery Pages";
	private static $singular_name = "Photo Gallery Holder";
	private static $icon = 'basic-galleries/images/holder';
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main',
			new LiteralField("addnew","<p><a href='".Director::absoluteBaseURL()."admin/pages/add/AddForm?action_doAdd=1&ParentID=".$this->ID."&PageType=PhotoGalleryPage&SecurityID=".SecurityToken::getSecurityID()."' class='ss-ui-button ss-ui-action-constructive ui-button' style='font-size:130%' data-icon=add''>New Photo Gallery</span></a></p>"),'Title');
	    return $fields;
	 }
	
	function ChildHolders() {
		return PhotoGalleryHolder::get()->filter(array("ParentID"=>$this->ID));
	}
	
	function AllGalleries() {
		return PhotoGalleryPage::get()->filter(array("ParentID" => $this->ID));
	}
	 
}

class PhotoGalleryHolder_Controller extends Page_Controller {

	public function init() {
      if(Director::fileExists(project() . "/css/gallery.css")) {
         Requirements::css(project() . "/css/gallery.css");
      }else{
         Requirements::css("basic-galleries/css/gallery.css");
      }
      parent::init();  
   }
   
   function Galleries() {
		$list = new PaginatedList(PhotoGalleryPage::get()->filter(array("ParentID" => $this->ID))->sort("Created DESC"), $this->request);
		$list->setPageLength(10);
		return $list;
	}
	
	
}
