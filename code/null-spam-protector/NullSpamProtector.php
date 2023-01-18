<?php

namespace SilverStripe\FrameworkTest\NullSpamProtector;

use SilverStripe\Forms\HiddenField;
use SilverStripe\SpamProtection\SpamProtector;

if (!interface_exists(SpamProtector::class)) {
    return;
}

/**
 * This is a minimum implementation used in CI for silverstripe/spamprotector so there's a default_spam_protector
 *
 * This used to be done by silverstripe/akismet, but that's no longer being used in CMS 5
 */
class NullSpamProtector implements SpamProtector
{
    public function getFormField($name = null, $title = null, $value = null)
    {
        return new HiddenField('NullSpamProtector');
    }

    public function setFieldMapping($fieldMapping)
    {
        // no-op
    }
}
