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
    private static $icon = 'purplespider/basic-galleries:client/dist/images/holder-file.gif';
    
    // public function getCMSFields()
    // {
    //     $fields = parent::getCMSFields();
    // 
    //     $fields->addFieldToTab('Root.Main',
    //         new LiteralField("addnew", "<p><a href='".Director::absoluteBaseURL()."admin/pages/add/AddForm?action_doAdd=1&ParentID=".$this->ID."&PageType=PhotoGalleryPage&SecurityID=".SecurityToken::getSecurityID()."' class='ss-ui-button ss-ui-action-constructive ui-button' style='font-size:130%' data-icon=add''>New Photo Gallery</span></a></p>"), 'Title');
    //     return $fields;
    // }
    
    public function ChildHolders()
    {
        return PhotoGalleryHolder::get()->filter(array("ParentID"=>$this->ID));
    }
    
    public function AllGalleries()
    {
        return PhotoGalleryPage::get()->filter(array("ParentID" => $this->ID));
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
