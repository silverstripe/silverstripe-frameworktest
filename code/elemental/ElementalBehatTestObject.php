<?php

namespace SilverStripe\FrameworkTest\Elemental\Model;

use SilverStripe\FrameworkTest\Elemental\Admin\ElementalBehatTestAdmin;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataObject;

class ElementalBehatTestObject extends DataObject
{
    private static $table_name = 'ElementalBehatTestObject';

    public function CMSEditLink()
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
}
