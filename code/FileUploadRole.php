<?php
class FileUploadRole extends DataExtension{
	function extraStatics() {
		return array(
			'has_one' => array(
				'AFile' => 'File',
				'AImage' => 'Image',
			),
		);
	}
}
?>