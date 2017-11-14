<?php

use SilverStripe\ORM\DataExtension;

class BasicFieldsTestFileExtension extends DataExtension
{
    private static $has_one = [
        'TestPage' => BasicFieldsTestPage::class,
    ];
}
