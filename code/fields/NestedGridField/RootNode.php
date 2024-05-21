<?php

namespace SilverStripe\FrameworkTest\Fields\NestedGridField;

use SilverStripe\ORM\DataObject;

class RootNode extends DataObject
{
  private static $table_name = 'NestedGridField_RootNode';

  private static $db = [
    'Name' => 'Varchar(50)',
  ];

  private static $has_many = [
    'BranchNodes' => BranchNode::class,
  ];
}
