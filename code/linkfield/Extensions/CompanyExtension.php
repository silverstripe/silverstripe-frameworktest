<?php

namespace SilverStripe\FrameworkTest\LinkField\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\LinkField;
use SilverStripe\LinkField\Form\MultiLinkField;
use SilverStripe\LinkField\Models\ExternalLink;

class CompanyExtension extends Extension
{
    private static array $has_one = [
        'CompanyWebSiteLink' => Link::class,
    ];

    private static $has_many = [
        'ManyCompanyWebSiteLink' => Link::class . '.Owner',
    ];

    private static array $owns = [
        'CompanyWebSiteLink',
        'ManyCompanyWebSiteLink',
    ];

    private static array $cascade_deletes = [
        'CompanyWebSiteLink',
        'ManyCompanyWebSiteLink',
    ];

    private static array $cascade_duplicates = [
        'CompanyWebSiteLink',
        'ManyCompanyWebSiteLink',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(['CompanyWebSiteLinkID', 'ManyCompanyWebSiteLinkID']);

        $fields->addFieldsToTab(
            'Root.Main',
            [
                LinkField::create('CompanyWebSiteLink', 'Company Website link')
                    ->setAllowedTypes([ExternalLink::class]),
                MultiLinkField::create('ManyCompanyWebSiteLink', 'Multiple Company Website link'),
            ]
        );
    }
}
