<?php

class RelationFieldsTestPage extends TestPage {
	static $many_many = array(
		"CheckboxSet" => "TestCategory",
	);
	static $has_may = array(
		"Items" => "TestCTFItem",
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab("Root.Content.CheckboxSet", 
			new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map()));

		$fields->addFieldToTab("Root.Content.ComplexTableField", 
			new ComplexTableField($this, "Items", "TestCTFItem", array(
				"Title" => "Item Title", 
				"Author" => "Item Author")));

//		$fields->addFieldToTab("Root.Tests.ComplexTableField", 
//			new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map()));
//		$fields->addFieldToTab("Root.Tests.CheckboxSet", new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map()));

		return $fields;
	}
}

class RelationFieldsTestPage_Controller extends TestPage_Controller {
	
}

?>