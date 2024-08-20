<?php

use SilverStripe\Core\Extension;

class BasicFieldsTestFileExtension extends Extension
{
    private static $has_one = [
        'TestPage' => BasicFieldsTestPage::class,
    ];
}
