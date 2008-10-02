<?php

/**
 * Parent class of all test pages
 */
class TestPage extends Page {
	
	/**
	 * We can only create subclasses of TestPage
	 */
	function canCreate() {
		return $this->class != 'TestPage' && parent::canCreate();
	}

	function requireDefaultRecords(){
		if($this->class == 'TestPage') return;

		$class = $this->class;
		if(!DataObject::get_one($class)) {
			$page = new $class();
			$page->Title = str_replace("TestPage","",$class) . " Test";
			$page->write();
			Debug::show($page);
			$page->doPublish();
		}
	}
	
}

/**
 * Parent class of all test page controllers
 */
class TestPage_Controller extends Page_Controller {
	
}
?>