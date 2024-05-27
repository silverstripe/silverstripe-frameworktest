<?php

namespace SilverStripe\FrameworkTest\Fields\NestedGridField;

use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataObject;
use Symbiote\GridFieldExtensions\GridFieldNestedForm;

class BranchNode extends DataObject
{
  private static $table_name = 'NestedGridField_BranchNode';

  private static $db = [
    'Name' => 'Varchar(50)',
    'Category' => 'Varchar(50)',
  ];

  private static $has_one = [
    'RootNode' => RootNode::class,
  ];

  private static $has_many = [
    'LeafNodes' => LeafNode::class,
  ];

  private static $summary_fields = [
    'Name',
    'Category',
  ];

  public function getNestedConfig(): GridFieldConfig
  {
      $config = new GridFieldConfig_RecordEditor();
      $config->addComponent(GridFieldNestedForm::create()->setRelationName('LeafNodes'));
      return $config;
  }
}
