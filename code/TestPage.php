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
	/**
	 * This form is exactly like the CMS form.  It gives us an opportunity to test the fields outside of the CMS context
	 */
	function Form() {
		$fields = $this->getCMSFields();
		$actions = new FieldSet(new FormAction("save", "Save"));
		$form = new Form($this, "Form", $fields, $actions);
		$form->loadDataFrom($this->dataRecord);
		return $form;
	}
	
	function save($data, $form) {
		$form->saveInto($this->dataRecord);
		$this->dataRecord->write();
		Director::redirectBack();
	}
}
?>