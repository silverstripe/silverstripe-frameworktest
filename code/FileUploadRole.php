<?php
class FileUploadRole extends DataObjectDecorator{
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