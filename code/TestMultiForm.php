<?php
class TestMultiForm extends MultiForm {
	public static $start_step = 'TestMultiFormStepOne';
	
	function finish($data, $form) {
		parent::finish($data, $form);
		
		$savedSteps = $this->getSavedSteps();
		
		$savedData = array();
		foreach($savedSteps as $step) {
			$savedData = array_merge($savedData, $step->loadData());
		}
		
		$fields = new FieldSet();
		$fields->push(new LiteralField("Heading", "<h3>You have submitted the following information:</h3>"));
		
	    foreach($savedData as $key=>$value)  {			
			$fields->push(new LiteralField($key . '_copy', "<p><strong>$key</strong> $value</p>"));
		}
		
		Session::set("MultiFormMessage", "Your information has been submitted.");
		
		Director::redirect(Director::BaseURL() . $this->Controller()->URLSegment);
	}
}

class TestMultiFormStepOne extends MultiFormStep {
	public static $next_steps = 'TestMultiFormStepTwo';
	
	function getFields() {
	    return new FieldSet(
	    	new TextField('FirstName', 'First name'),
			new TextField('Surname', 'Surname')
		);
	}
	
}

class TestMultiFormStepTwo extends MultiFormStep {
	public static $next_steps = 'TestMultiFormStepThree';
	
	function getFields() {
		
	    return new FieldSet(
	    	new TextField('Email', 'Email'),
			new TextField('Address', 'Address')
		);
	}
}


class TestMultiFormStepThree extends MultiFormStep {
	protected static $is_final_step = true;
	
	function getFields() {
		$form = $this->getForm();
		$savedSteps = $form->getSavedSteps();
	
		$savedData = array();
		foreach($savedSteps as $step) {
			$savedData = array_merge($savedData, $step->loadData());
		}
		
		$fields = new FieldSet();
		$fields->push(new LiteralField("Heading", "<h3>You have submitted the following information:</h3>"));
		
	    foreach($savedData as $key=>$value)  {
			if(preg_match("/_copy$/", $key)) continue;
			
			$fields->push(new LiteralField($key . '_copy', "<p><strong>$key</strong> $value</p>"));
		}
		
		return $fields;
	}
}

