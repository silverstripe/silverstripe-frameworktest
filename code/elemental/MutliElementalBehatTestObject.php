<?php

namespace SilverStripe\FrameworkTest\Elemental\Model;

use SilverStripe\Admin\CMSEditLinkExtension;
use SilverStripe\FrameworkTest\Elemental\Admin\MutliElementalBehatTestAdmin;
use SilverStripe\ORM\DataObject;

class MultiElementalBehatTestObject extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
    ];

    private static $table_name = 'ElementalMultiBehatTestObject';

    private static array $extensions = [
        CMSEditLinkExtension::class,
    ];

    private static string $cms_edit_owner = MutliElementalBehatTestAdmin::class;

    public function canView($member = null)
    {
        return true;
    }

    public function canEdit($member = null)
    {
        return true;
    }

    public function canDelete($member = null)
    {
        return true;
    }

    public function canCreate($member = null, $context = [])
    {
        return true;
    }
}
