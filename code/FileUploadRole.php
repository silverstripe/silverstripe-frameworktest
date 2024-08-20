<?php

use SilverStripe\Core\Extension;

class FileUploadRole extends Extension
{
    private static $has_one = array(
        'AFile' => 'SilverStripe\\Assets\\File',
        'AImage' => 'SilverStripe\\Assets\\Image',
    );
}
