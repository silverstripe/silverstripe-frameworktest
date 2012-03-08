<?php
class FrameworkTestSiteTreeExtension extends DataExtension {
	
	function extraStatics() {
		return array(
			'has_one' => array('RelationFieldsTestPage' => 'RelationFieldsTestPage'),
			'belongs_many_many' => array('RelationFieldsTestPages' => 'RelationFieldsTestPage'),
		);
	}

}