<?php
class FileUploadRole extends DataExtension
{
    private static $has_one = array(
        'AFile' => 'File',
        'AImage' => 'Image',
    );
}
