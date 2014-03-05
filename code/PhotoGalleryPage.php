<?php

class PhotoGalleryPage extends Page {
	
	private static $description = "A page including a photo gallery and the ability to bulk upload images";
	private static $icon = 'basic-galleries/images/gallery';
	private static $singular_name = "Photo Gallery";
	
	// One gallery page has many gallery images
	private static $has_many = array(
    	'PhotoGalleryImages' => 'PhotoGalleryImage'
  	);
  	
  	private static $defaults = array(
		'ShowInMenus' => false
	);
	
	public function getCMSFields() {

	    $fields = parent::getCMSFields();
	    
	    // Makes Image Gallery Tab Default, if images exist
	    if ($this->PhotoGalleryImages()->exists()) {
			$fields->insertBefore(new Tab('ImageGallery'), 'Main');
		}
	    
		$gridFieldConfig = GridFieldConfig_RecordEditor::create();
		$gridFieldConfig->addComponent(new GridFieldBulkImageUpload());
		
		$gridFieldConfig->getComponentByType('GridFieldBulkImageUpload')->setConfig('folderName', "Managed/PhotoGalleries/".$this->ID."-".$this->URLSegment);
		
		$gridFieldConfig->removeComponentsByType('GridFieldPaginator');
		$gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));
		$gridFieldConfig->addComponent(new GridFieldPaginator(30)); 
		$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
		
		$gridfield = new GridField("PhotoGalleryImages", "Image Gallery", $this->PhotoGalleryImages()->sort("SortOrder"), $gridFieldConfig);
		$fields->addFieldToTab('Root.ImageGallery', $gridfield);
		
		$fields->renameField("Content", "Intro Text");
		
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
	
	public function GetGalleryImages() {
		return $this->PhotoGalleryImages()->sort("SortOrder");
	}
	
}