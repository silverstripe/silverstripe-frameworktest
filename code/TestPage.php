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
			$page->doPublish();
		}
	}
	
}

/**
 * Parent class of all test page controllers
 */
class TestPage_Controller extends Page_Controller {
	static $allowed_actions = array(
		'makelotsofpages',
		'Form',
		'save',
	);
	
	/**
	 * This form is exactly like the CMS form.  It gives us an opportunity to test the fields outside of the CMS context
	 */
	function Form() {
		$fields = $this->getCMSFields();
		$actions = new FieldSet(
			new FormAction("save", "Save"),
			new ImageFormAction("gohome", "Go home", "frameworktest/images/test-button.png")
		);
		$form = new Form($this, "Form", $fields, $actions);
		$form->loadDataFrom($this->dataRecord);
		return $form;
	}
	
	function save($data, $form) {
		$form->saveInto($this->dataRecord);
		$this->dataRecord->write();
		Director::redirectBack();
	}
	
	function gohome() {
		Director::redirect("./");
	}
	
	/**
	 * Create a bunch of pages
	 */
	function makelotsofpages() {
		echo "<h1>Making pages</h1>";
		$this->makePages(5,5);
	}
	
	function makePages($count, $depth, $prefix = "", $parentID = 0) {
		for($i=1;$i<=$count;$i++) {
			$page = new Page();
			$page->ParentID = $parentID;
			$page->Title = "Test page $prefix$i";
			$page->write();
			$page->doPublish();

			echo "<li>Created '$page->Title'";
			if($depth > 1) $this->makePages($count, $depth-1, $prefix."$i.", $page->ID);
		}
	}
}
?>