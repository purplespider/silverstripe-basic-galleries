<?php

class PhotoGalleryImage extends DataObject
{
 
    private static $db = array(
        'SortOrder' => 'Int',
        'Title' => 'Varchar(255)'
    );
    
    private static $has_one = array(
        'Image' => 'Image',
        'PhotoGalleryPage' => 'Page'
    );
    
    private static $summary_fields = array(
       'Title' => 'Caption',
       'Thumbnail' => 'Thumbnail'
    );

    private static $default_sort = "SortOrder ASC";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        $fields->renameField("Title", "Caption");
        $fields->removeFieldFromTab("Root.Main", "SortOrder");
        $fields->removeFieldFromTab("Root.Main", "PhotoGalleryPageID");
        
        return $fields;
    }
        
    public function getThumbnail()
    {
        return $this->Image()->CMSThumbnail();
    }
    
    public function getThumb()
    {
        return $this->Image()->croppedImage(170, 140);
    }
    
    public function canCreate($members = null)
    {
        return true;
    }
    
    public function canEdit($members = null)
    {
        return true;
    }
    
    public function canDelete($members = null)
    {
        return true;
    }
    
    public function canView($members = null)
    {
        return true;
    }
}
