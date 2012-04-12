<?php
class FrameworkTestSiteTreeExtension extends DataExtension {
	
	function extraStatics($class = null, $extension = null) {
		return array(
			'has_one' => array('RelationFieldsTestPage' => 'RelationFieldsTestPage'),
			'belongs_many_many' => array('RelationFieldsTestPages' => 'RelationFieldsTestPage'),
		);
	}

}
