<?php

namespace PurpleSpider\BasicGalleries;


use Page;
use PageController;
use SilverStripe\Control\Director;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Security\SecurityToken;
use PurpleSpider\BasicGalleries\PhotoGalleryPage;


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

        $fields->renameField("Content", "Top Content");

        $fields->addFieldToTab("Root.Main", NumericField::create('PageLength', 'Number of galleries to display per page')->setDescription('Default: 10'), 'Metadata');
        return $fields;
    }

    public function ChildHolders()
    {
        return PhotoGalleryHolder::get()->filter(array("ParentID" => $this->ID));
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

    public function PaginatedGalleries()
    {
        $list = new PaginatedList(PhotoGalleryPage::get()->filter(array("ParentID" => $this->ID))->sort("Created DESC"), Controller::curr()->getRequest());
        $list->setPageLength($this->getMyPageLength());
        return $list;
    }

    // To avoid breaking earlier templates
    function Galleries()
    {
        return $this->PaginatedGalleries();
    }
}
