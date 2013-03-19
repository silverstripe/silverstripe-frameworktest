<?php
class FrameworkTestSiteTreeExtension extends DataExtension {
	
	static $has_one = array('RelationFieldsTestPage' => 'RelationFieldsTestPage');
	static $belongs_many_many = array('RelationFieldsTestPages' => 'RelationFieldsTestPage');

}
