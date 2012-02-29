<?php
class TestTag extends DataObject {
	
	static $db = array(
		'Title' => 'Text'
	);
	
	static $belongs_many_many = array(
		'Pages' => 'TestTagFieldPage'
	);
	
	function requireDefaultRecords(){
		$class = $this->class;
		if(!DataObject::get_one($class)) {
			foreach(array('one', 'two', 'three', 'four') as $title) {
				$tag = new $class();
				$tag->Title = $title;
				$tag->write();
			}
			
		}
	}
}