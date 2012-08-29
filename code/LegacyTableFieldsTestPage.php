<?php

class LegacyTableFieldsTestPage extends TestPage {

	function getCMSFields() {
		$fields = parent::getCMSFields();

		$tf = new TableListField('CompaniesTF', 'Company');
		$tf->setShowPagination(true);
		$ctf = new ComplexTableField($this, 'CompaniesCTF', 'Company');
		
		$fields->addFieldsToTab('Root.Fields', array(
			$tf,
			$ctf
		));

		return $fields;
	}
}

class LegacyTableFieldsTestPage_Controller extends TestPage_Controller {
	
}
