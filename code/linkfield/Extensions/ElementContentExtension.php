<?php

namespace SilverStripe\FrameworkTest\LinkField\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\LinkField\Form\LinkField;
use SilverStripe\LinkField\Form\MultiLinkField;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Models\EmailLink;
use SilverStripe\LinkField\Models\PhoneLink;
use SilverStripe\LinkField\Models\SiteTreeLink;

class ElementContentExtension extends Extension
{
    private static bool $inline_editable = true;

    private static array $has_one = [
        'OneLink' => Link::class,
    ];

    private static $has_many = [
        'ManyLinks' => Link::class . '.Owner',
    ];

    private static array $owns = [
        'OneLink',
        'ManyLinks',
    ];

    private static array $cascade_deletes = [
        'OneLink',
        'ManyLinks',
    ];

    private static array $cascade_duplicates = [
        'OneLink',
        'ManyLinks',
    ];

    protected function updateCMSFields($fields)
    {
        $fields->removeByName(['OneLinkID', 'ManyLinks']);
        $fields->addFieldsToTab(
            'Root.Main',
            [
                LinkField::create('OneLink', 'Single Link')
                    ->setAllowedTypes([
                        SiteTreeLink::class,
                        EmailLink::class,
                        PhoneLink::class
                    ]),
                MultiLinkField::create('ManyLinks', 'Multiple Links'),
            ],
        );
    }
}
