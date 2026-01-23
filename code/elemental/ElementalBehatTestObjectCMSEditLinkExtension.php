<?php

namespace SilverStripe\FrameworkTest\Elemental\Model;

use SilverStripe\Core\Extension;
use SilverStripe\FrameworkTest\Elemental\Admin\ElementalBehatTestAdmin;
use SilverStripe\Control\Controller;

class ElementalBehatTestObjectCMSEditLinkExtension extends Extension
{
    protected function updateCMSEditLink(&$link): void
    {
        $admin = ElementalBehatTestAdmin::singleton();
        $sanitisedClassname = str_replace('\\', '-', $this->getOwner()->ClassName);
        $link = Controller::join_links(
            $admin->Link($sanitisedClassname),
            'EditForm/field/',
            $sanitisedClassname,
            'item',
            $this->getOwner()->ID,
        );
    }
}
