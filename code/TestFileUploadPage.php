<?php

class TestFileUploadPage extends TestPage{
	
}

class TestFileUploadPage_Controller extends TestPage_Controller{
	
	function Form(){
		$fields = new FieldList(
			new EmailField('Email', 'EmailField'),
			new FileField('AFile','FileField'),
			$aImage = new UploadField('AImage','SimpleImageField')
		);
		
		$aImage->allowedExtensions = array('jpg', 'gif', 'png');
		
		$actions = new FieldList(
			new FormAction('addMember', "Add a member with two Files uploaded")
		);
		return new Form($this, "Form", $fields, $actions);
	}
	
	function addMember($data, $form){
		$member = new Member();
		$form->saveInto($member);
		$member->write();
		Director::redirectBack();
	}
}