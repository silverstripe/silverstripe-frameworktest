<?php

namespace SilverStripe\FrameworkTest\LinkField\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\LinkField\Models\Link;
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

    protected function updateCMSFields(FieldList $fields)
    {
        $fields->dataFieldByName('CompanyWebSiteLink')->setAllowedTypes([ExternalLink::class]);
    }
}
