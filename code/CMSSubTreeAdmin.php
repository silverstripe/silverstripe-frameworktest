<?php

/**
 * Test a subtree-admin that only shows the children of a FTPageHolder
 */
class CMSSubTreeAdmin extends CMSMain {
	// These variables are 2.3-specific; in 2.2.x you will need to edit _config.php
	static $url_segment = 'subtree';
	static $menu_title = 'FT Pages';
	
	function SiteTreeAsUL() {
		// This piece of code just gets us a root ID to use
		$ftRoot = DataObject::get_one("FTPageHolder");
		if(!$ftRoot) {
			$ftRoot = new FTPageHolder();
			$ftRoot->write();
		}
		
		// This code is what you will need to do to make a subtree version of CMSMain
		$this->generateDataTreeHints();
		$this->generateTreeStylingJS();
		
		// ftRoot->ID is your root node
		$siteTree = $this->getSiteTreeFor("SiteTree", $ftRoot->ID);
		
		// This code is copied from getSiteTreeFor(), because getSiteTreeFor has it hard-coded to only generate if rootID = 0
		$rootLink = $this->Link() . '0';
		if($this->hasMethod('getCMSTreeTitle')) $treeTitle = $this->getCMSTreeTitle();
		else $treeTitle =  _t('LeftAndMain.SITECONTENTLEFT',"Site Content",PR_HIGH,'Root node on left');
		$siteTree = "<ul id=\"sitetree\" class=\"tree unformatted\"><li id=\"record-0\" class=\"Root nodelete\"><a href=\"$rootLink\"><strong>$treeTitle</strong></a>"
			. $siteTree . "</li></ul>";

		return $siteTree;
	}
}

?>