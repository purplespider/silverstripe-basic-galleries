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
    private static $cms_icon_class = 'font-icon-p-gallery-alt';
    private static $table_name = 'PurpleSpider_BasicGalleries_PhotoGalleryPage';
    private static $singular_name = "Image Gallery";

    private static $defaults = array(
        'ShowInMenus' => false
    );

    #[\Override]
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if (!$contentCMSTab = $this->config()->get('content-cms-tab')) {
          $contentCMSTab = "Main";
        }

        $insertContentBefore = null;
        if ($contentCMSTab == "Main") {
          $insertContentBefore = "Metadata";
        }

        $fields->addFieldToTab("Root.".$contentCMSTab, HTMLEditorField::create('Content', 'Top Content'),$insertContentBefore);

        return $fields;
    }

    #[\Override]
    protected function onBeforeWrite()
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
