<?php

namespace PurpleSpider\BasicGalleries;


use SilverStripe\Control\Director;
use SilverStripe\Security\SecurityToken;
use SilverStripe\Forms\LiteralField;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\PaginatedList;
use PageController;
use Page;


class PhotoGalleryHolder extends Page
{

    private static $description = "Container for multiple Image Gallery pages";
    private static $singular_name = "Image Gallery Holder";
    private static $icon_class = 'font-icon-p-gallery';
    private static $allowed_children = array(PhotoGalleryPage::class);
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
    
        $fields->addFieldToTab('Root.Main',
            new LiteralField("addnew", "<p><a href='".Director::absoluteBaseURL()."admin/pages/add/AddForm?action_doAdd=1&ParentID=".$this->ID."&PageType=PurpleSpider%5CBasicGalleries%5CPhotoGalleryPage&SecurityID=".SecurityToken::getSecurityID()."' class='btn btn-primary font-icon-plus'>New Image Gallery</span></a></p>"), 'Title');
            
            $fields->renameField("Content", "Top Content");
        return $fields;
    }
    
    public function ChildHolders()
    {
        return PhotoGalleryHolder::get()->filter(array("ParentID"=>$this->ID));
    }
    
    public function AllGalleries()
    {
        return PhotoGalleryPage::get()->filter(array("ParentID" => $this->ID));
    }
    
    public function getLumberjackTitle()
    {
        return "Photo Galleries";
    }
    
    public function getLumberjackPagesForGridfield($excluded = array())
  	{
  			return PhotoGalleryPage::get()->filter(array(
  					'ParentID' => $this->ID,
  					'ClassName' => $excluded,
  			))->sort('Created DESC');
  	}
}

class PhotoGalleryHolder_Controller extends PageController
{

    public function Galleries()
    {
        $list = new PaginatedList(PhotoGalleryPage::get()->filter(array("ParentID" => $this->ID))->sort("Created DESC"), $this->request);
        $list->setPageLength(10);
        return $list;
    }
}
