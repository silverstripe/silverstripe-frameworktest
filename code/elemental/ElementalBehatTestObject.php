<?php

namespace SilverStripe\FrameworkTest\Elemental\Model;

use SilverStripe\FrameworkTest\Elemental\Admin\ElementalBehatTestAdmin;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

class ElementalBehatTestObject extends DataObject
{
    private static $table_name = 'ElementalBehatTestObject';

    public function getCMSEditLink(): ?string
    {
        $admin = ElementalBehatTestAdmin::singleton();
        $sanitisedClassname = str_replace('\\', '-', $this->ClassName);

        return Controller::join_links(
            $admin->Link($sanitisedClassname),
            'EditForm/field/',
            $sanitisedClassname,
            'item',
            $this->ID,
        );
    }

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
