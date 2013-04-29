<?php
// class TestTagFieldPage extends Page {
	
// 	private static $db = array(
// 		'TestTagString' => 'Text',
// 		'FixedTags' => 'Text'
// 	);
	
// 	private static $many_many = array(
// 		'TestTags' => 'TestTag',
// 	);
	
// 	function getCMSFields() {
// 		$fields = parent::getCMSFields();
		
// 		$tf1 = new TagField('TestTagString', "Single column tags (try 'one', 'two', 'three', 'four')", null, 'TestTagFieldPage');
// 		$fields->addFieldToTab('Root.Main', $tf1);
		
// 		$tf2 = new TagField('TestTags', "Relation tags (try 'one', 'two', 'three', 'four')");
// 		$fields->addFieldToTab('Root.Main', $tf2);
		
// 		$tf3 = new TagField('FixedTags', "Fixed tags (try 'PHP', 'Ruby', 'Python')", null, 'TestTag');
// 		$tf3->setCustomTags(array('PHP', 'Ruby', 'Python'));
// 		$fields->addFieldToTab('Root.Main', $tf3);
		
// 		return $fields;
// 	}
	
// 	function requireDefaultRecords(){
// 		$class = $this->class;
// 		if(!DataObject::get_one($class)) {
// 			$page = new $class();
// 			$page->Title = "Test TagField";
// 			$page->write();
// 		}
// 	}
	
// }

// class TestTagFieldPage_Controller extends Page_Controller {}