<?php

namespace SilverStripe\FrameworkTest\Versioned\Model;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataObject;

class NonVersionedParentObject extends DataObject
{
    private static $table_name = 'FrameworkTest_NonVersionedParentObject';

    private static $db = [
        'Name'=>'Varchar(255)',
    ];

    private static $has_one = [
        'TestPageVersionedObject' => TestPageVersionedObject::class,
    ];

    private static $has_many  = [
        'VersionedChildObjects' => VersionedChildObject::class,
    ];

    private static $owns = ['VersionedChildObjects'];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
    
        $fields->addFieldToTab('Root.VersionedChildObjects', GridField::create(
            'VersionedChildObjects',
            'VersionedChildObjects',
            $this->VersionedChildObjects(),
            GridFieldConfig_RecordEditor::create()
        ));
    
        return $fields;
    }
}
