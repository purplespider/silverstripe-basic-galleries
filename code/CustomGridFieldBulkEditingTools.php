<?php
/**
 * Base Component for all 'GridFieldBulkEditingTools'
 * defines the common HTML fragment
 *
 * @author colymba
 * @package GridFieldBulkEditingTools
 */
class CustomGridFieldBulkEditingTools implements GridField_HTMLProvider
{
    public function getHTMLFragments($gridField)
		{			
			Requirements::css(BULK_EDIT_TOOLS_PATH . '/css/GridFieldBulkEditingTools.css');
			Requirements::css('basic-galleries/css/CustomGridFieldBulkEditingTools.css');
			
			return array(
					"before" => "<div style='margin-bottom:10px !important' id=\"bulkEditTools\">\$DefineFragment(bulk-edit-tools)</div>"
			);
    }
}