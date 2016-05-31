<?php

class PhotoGalleryExtension extends DataExtension
{
    
    // One gallery page has many gallery images
    private static $has_many = array(
    'PhotoGalleryImages' => 'PhotoGalleryImage'
    );
        
    public function updateCMSFields(FieldList $fields)
    {
        $gridFieldConfig = GridFieldConfig_RecordEditor::create();
        $gridFieldConfig->addComponent(new GridFieldBulkUpload());
        $gridFieldConfig->addComponent(new GridFieldGalleryTheme('Image'));
        $bulkUpload = $gridFieldConfig->getComponentByType('GridFieldBulkUpload');
        $bulkUpload->setUfSetup('setFolderName', "Managed/PhotoGalleries/".$this->owner->ID."-".$this->owner->URLSegment);
        $bulkUpload->setUfConfig('canAttachExisting', false);
        $bulkUpload->setUfConfig('canPreviewFolder', false);
        $bulkUpload->setUfConfig('overwriteWarning', false); // Required to ensure upload order is consistent
        $bulkUpload->setUfConfig('sequentialUploads', true);
        
        $gridFieldConfig->removeComponentsByType('GridFieldPaginator');
        $gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));
        $gridFieldConfig->addComponent(new GridFieldPaginator(100));
        $gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
        
        $gridfield = new GridField("PhotoGalleryImages", "Image Gallery", $this->owner->PhotoGalleryImages()->sort("SortOrder"), $gridFieldConfig);
        $fields->addFieldToTab('Root.ImageGallery', $gridfield);

        $fields->addFieldToTab('Root.ImageGallery', new LiteralField('help', "
			<h2>To upload new images:</h2>
			<ol>
			<li>1. Click the <strong>From your computer</strong> button above.</li>
			<li>2. <strong>Locate and select</strong> the image(s) you wish to upload.</li>
			<li>3. Click on <strong>Open/Choose</strong> and the image(s) will begin to upload.</li>
			<li>4. Click <strong>Finish</strong>.</li> 
			</ol>"));
                
        return $fields;
    }
    
    public function GetGalleryImages()
    {
        return $this->owner->PhotoGalleryImages()->sort("SortOrder");
    }
}
