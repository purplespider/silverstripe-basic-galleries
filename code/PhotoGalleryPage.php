<?php

namespace PurpleSpider\BasicGalleries;


use SilverStripe\Forms\Tab;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use PageController;
use Page;
use PurpleSpider\BasicGalleries\PhotoGalleryHolder;



class PhotoGalleryPage extends Page
{
    
    private static $description = " Includes a single image gallery with the ability to upload multiple images via the CMS";
    private static $icon = 'purplespider/basic-galleries:client/dist/images/gallery-file.gif';
    private static $singular_name = "Image Gallery";

    private static $defaults = array(
        'ShowInMenus' => false
    );
    
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
                // Makes Image Gallery Tab Default, if images exist
              if ($this->PhotoGalleryImages()->exists()) {
                  // $fields->insertBefore(new Tab('ImageGallery'), 'Main');
              } else {
                // $fields->addFieldToTab("Root.Main", LiteralField::create('addImagesHeader', '<h2>Add images to this gallery using the <strong>Image Gallery</strong> tab above.</h2>'),'Title');
              }
              // $fields->renameField("Content", "Top Content");
							
            });

        $fields = parent::getCMSFields();
        
        $fields->addFieldToTab("Root.TopContent", HTMLEditorField::create('Content', 'Top Content'));
                
        return $fields;
    }
    
    public function onBeforeWrite()
    {
            
        // Move to Photo Gallery Holder if created under something else
        if ($this->Parent()->ClassName != PhotoGalleryHolder::class && PhotoGalleryHolder::get()->count() > 0) {
            $this->ParentID = PhotoGalleryHolder::get()->first()->ID;
        }
                    
        parent::onBeforeWrite();
    }
}

class PhotoGalleryPageController extends PageController
{
}
