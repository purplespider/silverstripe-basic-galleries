<?php

namespace PurpleSpider\BasicGalleries;


use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;



class PhotoGalleryImage extends DataObject
{
 
    private static $db = [
        'SortOrder' => 'Int',
        'Title' => 'Varchar(255)'
    ];
    
    private static $has_one = [
        'Image' => Image::class,
        'PhotoGalleryPage' => 'Page'
    ];
    
    private static $summary_fields = [
      'Image.CMSThumbnail' => 'Image',
       'Title' => 'Caption',
    ];

    private static $table_name = 'PhotoGalleryImage';
    private static $default_sort = "SortOrder ASC, Created ASC";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        $fields->renameField("Title", "Caption");
        $fields->removeFieldFromTab("Root.Main", "SortOrder");
        $fields->removeFieldFromTab("Root.Main", "PhotoGalleryPageID");
        
        return $fields;
    }
    
    protected function onBeforeWrite()
    {

  		if (!$this->SortOrder) {
  			$this->SortOrder = PhotoGalleryImage::get()->max('SortOrder') + 1;
  		}
  		
  		parent::onBeforeWrite();
  	}

    public function canCreate($member = null, $context = array())
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
