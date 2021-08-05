<?php

namespace PurpleSpider\BasicGalleries;


use Page;
use PageController;
use SilverStripe\Control\Director;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Security\SecurityToken;


class PhotoGalleryHolder extends Page
{

    private static $db = [
        'PageLength' => 'Int'
    ];

    private static $defaults = [
        'PageLength' => '10',
    ];

    private static $description = "Container for multiple Image Gallery pages";
    private static $singular_name = "Image Gallery Holder";
    private static $table_name = 'PurpleSpider_BasicGalleries_PhotoGalleryHolder';
    private static $icon_class = 'font-icon-p-gallery';
    private static $allowed_children = array(PhotoGalleryPage::class);
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
    
        $fields->addFieldToTab('Root.Main',
            new LiteralField("addnew", "<p><a href='".Director::absoluteBaseURL()."admin/pages/add/AddForm?action_doAdd=1&ParentID=".$this->ID."&PageType=PurpleSpider%5CBasicGalleries%5CPhotoGalleryPage&SecurityID=".SecurityToken::getSecurityID()."' class='btn btn-primary font-icon-plus'>New Image Gallery</span></a></p>"), 'Title');
            
            $fields->renameField("Content", "Top Content");

            $fields->addFieldToTab("Root.Main", NumericField::create('PageLength', 'Number of galleries to display per page')->setDescription('Default: 10'),'Metadata');
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

    public function getMyPageLength()
    {
        return $this->PageLength ? $this->PageLength : 10;
    }
}

class PhotoGalleryHolder_Controller extends PageController
{

    public function Galleries()
    {
        $list = new PaginatedList(PhotoGalleryPage::get()->filter(array("ParentID" => $this->ID))->sort("Created DESC"), $this->request);
        $list->setPageLength($this->getMyPageLength());
        return $list;
    }

}
