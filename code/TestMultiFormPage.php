<?php
class TestMultiFormPage extends Page {
	
}

class TestMultiFormPage_Controller extends Page_Controller {
	
	function Form() {
		$form = new TestMultiForm($this, 'Form', new FieldSet(), new FieldSet());

		return $form;
	}
	
	function FormMessage() {
		if(Session::get('MultiFormMessage')) {
			$message = Session::get('MultiFormMessage');
			Session::clear('MultiFormMessage');
			
			return $message;
		}
		
		return false;
	}
}
