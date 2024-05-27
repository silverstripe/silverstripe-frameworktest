<?php

namespace SilverStripe\FrameworkTest\Fields\NestedGridField;

use SilverStripe\FrameworkTest\Model\Company;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;

class NonRelationalData extends DataObject
{
    private static $table_name = 'NestedGridField_NonRelationalData';

    private static $db = [
        'Name' => 'Varchar(50)',
    ];

    public function getList() {
        $list = ArrayList::create();
        $data = Company::get()->byIDs([1,2,3,4,5]);
        foreach ($data as $value) {
            $list->push($value);
        }

        return $list;
    }
}
