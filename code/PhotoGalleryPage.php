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
		$gridFieldConfig->addComponent(new GridFieldBulkUpload());
		$gridFieldConfig->addComponent(new GridFieldBulkManager());
		$gridFieldConfig->addComponent(new GridFieldGalleryTheme('Image'));
		$bulkUpload = $gridFieldConfig->getComponentByType('GridFieldBulkUpload');
		$bulkUpload->setConfig('folderName', "Managed/PhotoGalleries/".$this->ID."-".$this->URLSegment);
		$bulkUpload->setConfig('canAttachExisting',false);
		$bulkUpload->setConfig('canPreviewFolder',false);
		
		$gridFieldConfig->removeComponentsByType('GridFieldPaginator');
		$gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));
		$gridFieldConfig->addComponent(new GridFieldPaginator(100)); 
		$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
		
		$gridfield = new GridField("PhotoGalleryImages", "Image Gallery", $this->PhotoGalleryImages()->sort("SortOrder"), $gridFieldConfig);
		$fields->addFieldToTab('Root.ImageGallery', $gridfield);

		$fields->addFieldToTab('Root.ImageGallery', new LiteralField('help',"
			<h2>To upload new images:</h2>
			<ol>
			<li>1. Click the <strong>From your computer</strong> button above.</li>
			<li>2. <strong>Locate and select</strong> the image(s) you wish to upload.</li>
			<li>3. Click on <strong>Open/Choose</strong> and the image(s) will begin to upload.</li>
			<li>4. If you wish to add several image captions, then once all the images have all uploaded, click on the <strong>Edit all</strong> button.</li>
			<li>5. Click <strong>Finish</strong>.</li> 
			</ol>"));
		
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