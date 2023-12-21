<?php

namespace SilverStripe\FrameworkTest\Versioned\Model;

use Page;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class VersionedParentObject extends DataObject
{
    private static $table_name = 'FrameworkTest_VersionedParentObject';

    private static $extensions = [
        Versioned::class
    ];

    private static $db = [
        'Name'=>'Varchar(255)',
    ];

    private static $has_one = [
        'TestPageVersionedObject' => TestPageVersionedObject::class,
    ];

    private static $has_many  = [
        'NonVersionedChildObjects' => NonVersionedChildObject::class,
    ];

    private static $owns = ['NonVersionedChildObjects'];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
    
        $fields->addFieldToTab('Root.NonVersionedChildObjects', GridField::create(
            'NonVersionedChildObjects',
            'NonVersionedChildObjects',
            $this->NonVersionedChildObjects(),
            GridFieldConfig_RecordEditor::create()
        ));
    
        return $fields;
    }
}
