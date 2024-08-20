<?php

use SilverStripe\Core\Extension;

class FrameworkTestSiteTreeExtension extends Extension
{
    private static $has_one = array('RelationFieldsTestPage' => 'RelationFieldsTestPage');
    private static $belongs_many_many = array('RelationFieldsTestPages' => 'RelationFieldsTestPage');

    private static array $scaffold_cms_fields_settings = [
        'ignoreFields' => [
            'RelationFieldsTestPage',
        ],
        'ignoreRelations' => [
            'RelationFieldsTestPages',
        ],
    ];
}
