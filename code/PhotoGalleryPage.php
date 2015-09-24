<?php

class PhotoGalleryPage extends Page {
	
	private static $description = "A page including a photo gallery and the ability to bulk upload images";
	private static $icon = 'basic-galleries/images/gallery';
	private static $singular_name = "Photo Gallery";

  	
  	private static $defaults = array(
		'ShowInMenus' => false
	);
	
	public function getCMSFields() {
		
			$this->beforeUpdateCMSFields(function($fields) {
				// Makes Image Gallery Tab Default, if images exist
			  if ($this->PhotoGalleryImages()->exists()) {
					$fields->insertBefore(new Tab('ImageGallery'), 'Main');
				}
			});

	    $fields = parent::getCMSFields();
				
		return $fields;
	
	}	
	
  	function onBeforeWrite() {
			
		// Move to Photo Gallery Holder if created under something else
		if ($this->Parent()->ClassName != "PhotoGalleryHolder" && PhotoGalleryHolder::get()->count() > 0) {
			$this->ParentID = PhotoGalleryHolder::get()->first()->ID;
		}		
					
		parent::onBeforeWrite();
	}
}

class PhotoGalleryPage_Controller extends Page_Controller {

	
}