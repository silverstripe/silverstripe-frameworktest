<?php
class TestMultiFormPage extends Page {
	
}

class TestMultiFormPage_Controller extends Page_Controller {
	
	function Form() {
		$form = new TestMultiForm($this, 'Form', new FieldSet(), new FieldSet());

		return $form;
	}
}
