<?php

/**
 * Parent class of all test pages
 */
class TestPage extends Page {
	
	/**
	 * We can only create subclasses of TestPage
	 */
	function canCreate($member = null) {
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

	function EmailForm() {
		return new Form($this, "EmailForm", new FieldSet(
			new TextField("Email", "Email address")
		), new FieldSet(
			new FormAction("sendEmail", "Send test email to this address")
		));
	}
	
	function email() {
		return array(
			'Content' => '<p>Use this form to send a test email</p>',
			'Form' => $this->EmailForm()
		);
	}
	
	function sendEmail($data, $form) {
		$email = new Email();
		$email->setTo($data['Email']);
		$email->setFrom($data['Email']);
		$email->setSubject('A subject with some umlauts: öäüß');
		$email->setBody('A body with some umlauts: öäüß');
		$email->send();
		
		echo "<p>email sent to " . $data['Email'] . "</p>";
	}
}
?>
