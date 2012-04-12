<?php
class FileUploadRole extends DataExtension{
	function extraStatics($class = null, $extension = null) {
		return array(
			'has_one' => array(
				'AFile' => 'File',
				'AImage' => 'Image',
			),
		);
	}
}
?>
