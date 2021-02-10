<?php

namespace SilverStripe\FrameworkTest\Model;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\RequiredFields;

/**
 * This class is specifically for the silverstripe/admin behat test multitab-validation.feature
 */
class SingleTabPage extends SiteTree
{
    public function getCMSValidator()
    {
        return new RequiredFields([
            'Content'
        ]);
    }
}
