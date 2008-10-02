<?php

/**
 * A data type that is related 1-many to RelationFieldsTestPage, for testing purposes
 */
class TestCTFItem extends DataObject {
	static $db = array(
		"Title" => "Varchar",
		"Author" => "Varchar",
		"Description" => "Text",
	);
	static $has_one = array(
		"Parent" => "RelationFieldsTestPage",
	);
	
	/**
	 * Returns a dropdown map of all objects of this class
	 */
	static function map() {
		return DataObject::get('TestCategory')->toDropdownMap();
	}

}

?>