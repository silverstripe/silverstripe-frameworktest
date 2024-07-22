<?php

namespace SilverStripe\FrameworkTest\Elemental\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\FrameworkTest\Elemental\Extension\MultiElementalAreasExtension;

class MultiElementalBehatTestObject extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
    ];

    private static $table_name = 'ElementalMultiBehatTestObject';

    private static $extensions = [
        MultiElementalAreasExtension::class,
    ];

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
