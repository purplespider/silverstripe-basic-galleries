<?php

namespace PurpleSpider\BasicGalleries;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridField_ActionMenu;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Colymba\BulkUpload\BulkUploader;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;
use PurpleSpider\BasicGalleries\PhotoGalleryImage;

use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;


class PhotoGalleryExtension extends DataExtension
{
    
    // One gallery page has many gallery images
    private static $has_many = array(
    'PhotoGalleryImages' => PhotoGalleryImage::class
    );
    
    private static $owns = [
      'PhotoGalleryImages'
    ];
        
    public function updateCMSFields(FieldList $fields)
    {
        if (!$galleryCMSTab = $this->owner->config()->get('gallery-cms-tab')) {
          $galleryCMSTab = "Main";
        }
        
        $insertGalleryBefore = null;
        if ($galleryCMSTab == "Main") {
          $insertGalleryBefore = "Metadata";
        }
        
        if (!$galleryTitle = $this->owner->config()->get('gallery-title')) {
          $galleryTitle = "Image Gallery";
        }
    
        $gridFieldConfig = new GridFieldConfig();
        
        $gridFieldConfig->addComponent(new BulkUploader());
        $bulkUpload = $gridFieldConfig->getComponentByType(BulkUploader::class);
        $bulkUpload->setUfSetup('setFolderName', $this->getBulkUploadFolderName());
        
        $gridFieldConfig->addComponent(GridFieldOrderableRows::create()->setSortField('SortOrder'));
        $gridFieldConfig->addComponent(new GridFieldButtonRow('before'));
        $gridFieldConfig->addComponent(new GridFieldToolbarHeader());
        $gridFieldConfig->addComponent(new GridFieldSortableHeader());
        $gridFieldConfig->addComponent(new GridFieldFilterHeader());
        $gridFieldConfig->addComponent(new GridFieldEditableColumns());
        $gridFieldConfig->addComponent(new GridFieldEditButton());
        $gridFieldConfig->addComponent(new GridFieldDeleteAction());
        $gridFieldConfig->addComponent(new GridField_ActionMenu());
        $gridFieldConfig->addComponent(new GridFieldPageCount('toolbar-header-right'));
        $gridFieldConfig->addComponent(new GridFieldPaginator(100));
        $gridFieldConfig->addComponent(new GridFieldDetailForm());
        
        $gridfield = new GridField("PhotoGalleryImages", $galleryTitle, $this->owner->PhotoGalleryImages(), $gridFieldConfig);
        $fields->addFieldToTab('Root.'.$galleryCMSTab, HeaderField::create('addHeader','Add Images'),$insertGalleryBefore);
        $fields->addFieldToTab('Root.'.$galleryCMSTab, $gridfield,$insertGalleryBefore);
        
        return $fields;
    }
    
    public function GetGalleryImages()
    {
        return $this->owner->PhotoGalleryImages()->sort("SortOrder");
    }
    
    protected function getBulkUploadFolderName()
    {
        if ($this->owner->hasMethod('getBulkUploadFolderName')) {
            return $this->owner->getBulkUploadFolderName();
        }
        return "Managed/PhotoGalleries/".$this->owner->ID."-".$this->owner->URLSegment;
    }
}
