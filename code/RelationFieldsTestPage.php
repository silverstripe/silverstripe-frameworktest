<?php

class RelationFieldsTestPage extends TestPage {
	static $has_one = array(
		"FavouriteItem" => "TestCTFItem",
	);
	static $has_many = array(
		"Items" => "TestCTFItem",
	);
	static $many_many = array(
		"CheckboxSet" => "TestCategory",
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab("Root.Content.CheckboxSet", 
			new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map()));

		/*
		$fields->addFieldToTab("Root.Content.ComplexTableField", 
			new ComplexTableField($this, "Items", "TestCTFItem", array(
				"Title" => "Item Title", 
				"Author" => "Item Author")));
			*/

		$fields->addFieldToTab("Root.Content.HasOneComplexTableField", 
			new HasOneComplexTableField($this, "FavouriteItem", "TestCTFItem", array(
				"Title" => "Item Title", 
				"Author" => "Item Author")));

		$fields->addFieldToTab("Root.Content.HasManyComplexTableField", 
			new HasManyComplexTableField($this, "Items", "TestCTFItem", array(
				"Title" => "Item Title", 
				"Author" => "Item Author")));

		$fields->addFieldToTab("Root.Content.ManyManyComplexTableField", 
			new ManyManyComplexTableField($this, "CheckboxSet", "TestCategory", array(
				"Title" => "Item Title")));


//		$fields->addFieldToTab("Root.Tests.ComplexTableField", 
//			new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map()));
//		$fields->addFieldToTab("Root.Tests.CheckboxSet", new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map()));

		return $fields;
	}
}

class RelationFieldsTestPage_Controller extends TestPage_Controller {
	
}

?>