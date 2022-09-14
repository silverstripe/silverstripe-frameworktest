<?php

namespace SilverStripe\FrameworkTest\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Permission;
use SilverStripe\Security\PermissionProvider;

class TestDataObjectExtension extends DataExtension implements PermissionProvider
{
    public function providePermissions()
    {
        return [
            'TEST_DATAOBJECT_EDIT' => [
                'name' => _t(
                    __CLASS__ . '.EditPermissionLabel',
                    'Manage a test object'
                ),
                'category' => _t(
                    __CLASS__ . '.Category',
                    'Test Data Object'
                ),
            ],
        ];
    }

    public function canView($member = null) 
    {
        return Permission::check('TEST_DATAOBJECT_EDIT', 'any', $member);
    }

    public function canEdit($member = null) 
    {
        return Permission::check('TEST_DATAOBJECT_EDIT', 'any', $member);
    }

    public function canDelete($member = null) 
    {
        return Permission::check('TEST_DATAOBJECT_EDIT', 'any', $member);
    }

    public function canCreate($member = null, $context = []) 
    {
        return Permission::check('TEST_DATAOBJECT_EDIT', 'any', $member);
    }
}
