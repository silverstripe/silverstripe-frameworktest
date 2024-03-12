<?php

namespace SilverStripe\FrameworkTest\Versioned\Model;

use SilverStripe\ORM\DataObject;

class NonVersionedChildObject extends DataObject
{
    private static $table_name = 'FrameworkTest_NonVersionedChildObject';

    private static $db = [
        'Name'=>'Varchar(255)',
    ];

    private static $has_one = [
        'VersionedParentObject' => VersionedParentObject::class,
    ];
}
