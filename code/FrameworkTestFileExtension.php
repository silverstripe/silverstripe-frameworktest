<?php

use SilverStripe\ORM\DataExtension;
class FrameworkTestFileExtension extends DataExtension
{
    private static $has_one = array(
        'Company' => 'SilverStripe\\FrameworkTest\\Model\\Company',
        'BasicFieldsTestPage' => 'BasicFieldsTestPage'
    );
}
