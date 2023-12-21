<?php

namespace SilverStripe\FrameworkTest\Versioned\Model;

use Page;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use TestPageInterface;

/**
 * Parent class of all test pages
 */
class TestPageVersionedObject extends Page implements TestPageInterface
{
    private static $table_name = 'FrameworkTest_VersionedObject';

    private static $has_many = [
        'VersionedParentObjects' => VersionedParentObject::class,
        'NonVersionedParentObjects' => NonVersionedParentObject::class,
    ];
  
    private static $owns = [
        'VersionedParentObjects',
        'NonVersionedParentObjects',
    ];
  
    public function getCMSFields()
    {
      $fields = parent::getCMSFields();
  
      $fields->addFieldToTab('Root.VersionedParentObjects', GridField::create(
          'VersionedParentObjects',
          'VersionedParentObjects',
          $this->VersionedParentObjects(),
          GridFieldConfig_RecordEditor::create()
      ));

      $fields->addFieldToTab('Root.NonVersionedParentObjects', GridField::create(
          'NonVersionedParentObjects',
          'NonVersionedParentObjects',
          $this->NonVersionedParentObjects(),
          GridFieldConfig_RecordEditor::create()
      ));
  
      return $fields;
    }
}
