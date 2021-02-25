<?php

namespace SilverStripe\FrameworkTest\Model;

use Page;
use SilverStripe\Forms\RequiredFields;

if (!class_exists(Page::class)) {
    return;
}

/**
 * This class is specifically for the silverstripe/admin behat test multitab-validation.feature
 */
class SingleTabPage extends Page
{
    public function getCMSValidator()
    {
        return new RequiredFields([
            'Content'
        ]);
    }
}
