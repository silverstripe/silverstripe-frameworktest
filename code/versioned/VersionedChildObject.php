<?php

namespace SilverStripe\FrameworkTest\Versioned\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class VersionedChildObject extends DataObject
{
    private static $table_name = 'FrameworkTest_VersionedChildObject';

    private static $extensions = [
        Versioned::class,
    ];

    private static $db = [
        'Name'=>'Varchar(255)',
    ];

    private static $has_one = [
        'NonVersionedParentObject' => NonVersionedParentObject::class,
    ];
}
