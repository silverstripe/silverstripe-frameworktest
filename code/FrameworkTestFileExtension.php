<?php

use SilverStripe\Core\Extension;

class FrameworkTestFileExtension extends Extension
{
    private static $has_one = array(
        'Company' => 'SilverStripe\\FrameworkTest\\Model\\Company',
        'BasicFieldsTestPage' => 'BasicFieldsTestPage'
    );
}
