<?php

namespace PurpleSpider\MySite;

use SilverStripe\Dev\BuildTask;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\ORM\Queries\SQLUpdate;


class UpgradeBasicGalleriesTask extends BuildTask {

    protected $title = 'Upgrade Basic Galleries';
    private static $segment = 'upgrade-basic-galleries';
    protected $description = "Applies database updates for Basic Galleries polymorphic update";

    public function run($request) {
        
        $sqlQuery = new SQLSelect();
        $sqlQuery->setFrom('PhotoGalleryImage');
        $sqlQuery->selectField('PhotoGalleryPageID');
        $result = $sqlQuery->execute();

        $updatecount = 0;

        foreach($result as $row) {
            if(isset($row['PhotoGalleryPageID']) && $row['PhotoGalleryPageID']) {
                $page = SiteTree::get()->byID($row['PhotoGalleryPageID']);
                if($page->exists()) {
                    $pageClassname = $page->ClassName;
                    $update = SQLUpdate::create('"PhotoGalleryImage"')->addWhere(['ID' => $row['ID']]);
                    $update->assign('"AlbumID"', $row['PhotoGalleryPageID']);
                    $update->assign('"AlbumClass"', $pageClassname);
                    $update->assign('"PhotoGalleryPageID"', 0);
                    $update->execute();
                    $updatecount++;
                }
            }
            if(isset($row['PhotoGalleryBlockID']) && $row['PhotoGalleryBlockID']) {
                $update = SQLUpdate::create('"PhotoGalleryImage"')->addWhere(['ID' => $row['ID']]);
                $update->assign('"AlbumID"', $row['PhotoGalleryBlockID']);
                $update->assign('"AlbumClass"', "PurpleSpider\ElementalBasicGallery\ImageGalleryBlock");
                $update->assign('"PhotoGalleryBlockID"', 0);
                $update->execute();
                $updatecount++;
            }
        }

        echo($updatecount." records updated.");

    }

}