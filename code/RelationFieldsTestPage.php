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

	static $defaults = array(
		'Title' => 'Relational Fields'
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();

		$allFields = array();
		
		$checkboxFields = array(
			new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map())
		);
		$fields->addFieldsToTab("Root.CheckboxSet", $checkboxFields);
		$allFields += $checkboxFields;

		$treeFields = array(
			TreeDropdownField::create('HasOnePage', 'HasOnePage', 'SiteTree'),
			TreeMultiselectField::create('HasManyPages', 'HasManyPages', 'SiteTree'),
			TreeMultiselectField::create('ManyManyPages', 'ManyManyPages (with search)', 'SiteTree')->setShowSearch(true)
		);
		$fields->addFieldsToTab('Root.Tree', $treeFields);
		$allFields += $treeFields;

		foreach($allFields as $field) {
			$field
				->setDescription('This is <strong>bold</strong> help text')
				->addExtraClass('cms-help');
				// ->addExtraClass('cms-help cms-help-tooltip');
		}

		return $fields;
	}
}

class RelationFieldsTestPage_Controller extends TestPage_Controller {
	
}
