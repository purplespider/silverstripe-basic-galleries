<?php
 
class PhotoGalleryImage extends DataObject {
 
	public static $db = array(	
		'SortOrder' => 'Int',
		'Title' => 'Varchar(255)'
	);
	
	public static $has_one = array(
		'Image' => 'Image',
		'PhotoGalleryPage' => 'PhotoGalleryPage'
	);
	
	public static $summary_fields = array( 
	   'Title' => 'Title',
	   'Thumbnail' => 'Thumbnail'     
	);

	static $default_sort = "SortOrder ASC";

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab("Root.Main","SortOrder");
		$fields->removeFieldFromTab("Root.Main","PhotoGalleryPageID");
		
		return $fields;		
	}
		
	public function getThumbnail() { 
		return $this->Image()->CMSThumbnail();
	}
	
	public function getThumb() {
	 	return $this->Image()->croppedImage(170,140);
	}
	
	function canCreate($members = null) {
		return true;
	}
	
	function canEdit($members = null) {
		return true;
	}
	
	function canDelete($members = null) {
		return true;
	}
	
	function canView($members = null) {
		return true;
	}
 
}