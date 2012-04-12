<?php

class RelationFieldsTestPage extends TestPage {
	
	static $has_one = array(
		"HasOneCompany" => "Company",
		"HasOnePage" => "SiteTree",
	);
	static $has_many = array(
		"HasManyCompanies" => "Company",
		"HasManyPages" => "SiteTree",
	);
	static $many_many = array(
		"ManyManyCompanies" => "Company",
		"ManyManyPages" => "SiteTree",
	);
	
	function getCMSFields($class = null, $extension = null) {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab("Root.CheckboxSet",
			new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map())
		);

		$fields->addFieldsToTab('Root.Tree', array(
			TreeDropdownField::create('HasOnePage', 'HasOnePage', 'SiteTree'),
			TreeMultiselectField::create('HasManyPages', 'HasManyPages', 'SiteTree'),
			TreeMultiselectField::create('ManyManyPages', 'ManyManyPages (with search)', 'SiteTree')->setShowSearch(true)
		));

//		$fields->addFieldToTab("Root.Tests.ComplexTableField", 
//			new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map()));
//		$fields->addFieldToTab("Root.Tests.CheckboxSet", new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map()));

		return $fields;
	}
}

class RelationFieldsTestPage_Controller extends TestPage_Controller {
	
}
