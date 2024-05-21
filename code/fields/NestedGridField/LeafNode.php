<?php

namespace SilverStripe\FrameworkTest\Fields\NestedGridField;

use SilverStripe\ORM\DataObject;

class LeafNode extends DataObject
{
    private static $table_name = 'NestedGridField_LeafNode';

    private static $db = [
        'Name' => 'Varchar(50)',
        'Category'=>'Varchar(255)',
    ];

    private static $has_one = [
        'BranchNode' => BranchNode::class,
    ];

    private static $summary_fields = [
        'Name',
        'Category',
    ];
}
