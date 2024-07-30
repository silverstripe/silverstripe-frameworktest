<?php

namespace SilverStripe\FrameworkTest\Elemental\Model;

use SilverStripe\ORM\DataObject;

class MultiElementalBehatTestObject extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
    ];

    private static $table_name = 'ElementalMultiBehatTestObject';

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
