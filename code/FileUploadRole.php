<?php
class FileUploadRole extends DataExtension{
	static $has_one = array(
		'AFile' => 'File',
		'AImage' => 'Image',
	);
}
?>
