<?php

namespace SilverStripe\FrameworkTest\LinkField\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\LinkField;
use SilverStripe\LinkField\Form\MultiLinkField;
use SilverStripe\LinkField\Models\EmailLink;
use SilverStripe\LinkField\Models\PhoneLink;
use SilverStripe\LinkField\Models\SiteTreeLink;

class LinkPageExtension extends Extension
{
    private static array $has_one = [
        'HasOneLink' => Link::class,
    ];

    private static $has_many = [
        'HasManyLinks' => Link::class . '.Owner',
    ];

    private static array $owns = [
        'HasOneLink',
        'HasManyLinks',
    ];

    private static array $cascade_deletes = [
        'HasOneLink',
        'HasManyLinks',
    ];

    private static array $cascade_duplicates = [
        'HasOneLink',
        'HasManyLinks',
    ];

    protected function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(['Content', 'HasOneLinkID', 'HasManyLinksID']);

        $fields->addFieldsToTab(
            'Root.Main',
            [
                LinkField::create('HasOneLink', 'Single Link')
                    ->setAllowedTypes([
                        SiteTreeLink::class,
                        EmailLink::class,
                        PhoneLink::class
                    ]),
                MultiLinkField::create('HasManyLinks', 'Multiple Links'),
            ],
        );
    }
}
