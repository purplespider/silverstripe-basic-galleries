<?php

namespace PurpleSpider\BasicGalleries;


use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Colymba\BulkUpload\BulkUploader;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;
use PurpleSpider\BasicGalleries\PhotoGalleryImage;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;


class PhotoGalleryExtension extends DataExtension
{
    
    // One gallery page has many gallery images
    private static $has_many = array(
    'PhotoGalleryImages' => PhotoGalleryImage::class
    );
        
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
      
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->addComponent(new BulkUploader());
        // $gridFieldConfig->addComponent(new GridFieldGalleryTheme(Image::class));
        $bulkUpload = $gridFieldConfig->getComponentByType(BulkUploader::class);
        $bulkUpload->setUfSetup('setFolderName', "Managed/PhotoGalleries/".$this->owner->ID."-".$this->owner->URLSegment);
        // $bulkUpload->setUfConfig('canAttachExisting', false);
        // $bulkUpload->setUfConfig('canPreviewFolder', false);
        // $bulkUpload->setUfConfig('overwriteWarning', false); // Required to ensure upload order is consistent
        // $bulkUpload->setUfConfig('sequentialUploads', true);
        
        $gridFieldConfig->removeComponentsByType(GridFieldPaginator::class);
        // $gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));
        $gridFieldConfig->addComponent(GridFieldOrderableRows::create()->setSortField('SortOrder'));
        $gridFieldConfig->addComponent(new GridFieldPaginator(100));
        $gridFieldConfig->removeComponentsByType(GridFieldAddNewButton::class);
        
        $gridfield = new GridField("PhotoGalleryImages", $galleryTitle, $this->owner->PhotoGalleryImages()->sort("SortOrder"), $gridFieldConfig);
        $fields->addFieldToTab('Root.'.$galleryCMSTab, HeaderField::create('addHeader','Add Images'),$insertGalleryBefore);
        $fields->addFieldToTab('Root.'.$galleryCMSTab, $gridfield,$insertGalleryBefore);
        
        return $fields;
    }
    
    public function GetGalleryImages()
    {
        return $this->owner->PhotoGalleryImages()->sort("SortOrder");
    }
}
