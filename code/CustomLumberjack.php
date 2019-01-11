<?php

namespace PurpleSpider\BasicGalleries;

use SilverStripe\Lumberjack\Model\Lumberjack;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\Tab;
use SilverStripe\Dev\Debug;
use SilverStripe\CMS\Model\SiteTree;

class CustomLumberjack extends Lumberjack {

  /**
	 * This is responsible for adding the child pages tab and gridfield.
   * CUSTOM: Customised to make the GridField tab first.
	 *
	 * @param FieldList $fields
	 */
	public function updateCMSFields(FieldList $fields) {
		$excluded = $this->owner->getExcludedSiteTreeClassNames();
		if(!empty($excluded)) {
			$pages = $this->getLumberjackPagesForGridfield($excluded);
			$gridField = new GridField(
				"ChildPages",
				$this->getLumberjackTitle(),
				$pages,
				$this->getLumberjackGridFieldConfig()
			);

			$tab = new Tab('ChildPages', $this->getLumberjackTitle(), $gridField);
			
			// BEGIN CUSTOMISATION
			
			// $fields->insertAfter($tab, 'Main');
			
			if (SiteTree::get()->filter('ParentID',$this->owner->ID)->count()){
				$fields->insertBefore($tab, 'Main'); 
			} else {
				$fields->insertAfter($tab, 'Main'); 
			}
			// END CUSTOMISATION
			
		}
	}
  
}