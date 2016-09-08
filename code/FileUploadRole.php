<?php

use SilverStripe\ORM\DataExtension;
class FileUploadRole extends DataExtension
{
    private static $has_one = array(
        'AFile' => 'SilverStripe\\Assets\\File',
        'AImage' => 'SilverStripe\\Assets\\Image',
    );
}
