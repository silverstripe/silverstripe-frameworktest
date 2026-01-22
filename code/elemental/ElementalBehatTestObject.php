<?php

namespace SilverStripe\FrameworkTest\Elemental\Model;

use SilverStripe\FrameworkTest\Elemental\Admin\ElementalBehatTestAdmin;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

// Note that we should explicitly NOT add a getCMSEditLink
// implementation for this class, as one of the behat tests
// relies on it not having one.
class ElementalBehatTestObject extends DataObject
{
    private static $table_name = 'ElementalBehatTestObject';

    private static array $db = [
        'Title' => 'Varchar',
    ];

    public function canView($member = null)
    {
        return Permission::check(ElementalBehatTestAdmin::getRequiredPermissions() , 'any', $member);
    }

    public function canEdit($member = null)
    {
        return Permission::check(ElementalBehatTestAdmin::getRequiredPermissions(), 'any', $member);
    }

    public function canDelete($member = null)
    {
        return Permission::check(ElementalBehatTestAdmin::getRequiredPermissions(), 'any', $member);
    }

    public function canCreate($member = null, $context = [])
    {
        return Permission::check(ElementalBehatTestAdmin::getRequiredPermissions(), 'any', $member);
    }

}
