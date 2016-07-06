<?php
namespace SilverStripe\FrameworkTest\Model;

use SilverStripe\ORM\DataObject;

class Organisation extends DataObject
{

    private static $table_name = 'Organisation';

    // Used to test the Multiform module
    private static $db = array(
        'OrganisationName' => 'Text'
    );
}
