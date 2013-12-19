<?php
class FrameworkTestFileExtension extends DataExtension {
	private static $has_one = array(
		'Company' => 'Company',
		'BasicFieldsTestPage' => 'BasicFieldsTestPage'
	);
}