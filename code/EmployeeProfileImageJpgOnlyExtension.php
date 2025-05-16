<?php

namespace SilverStripe\FrameworkTest\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\FrameworkTest\Model\Employee;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;

/**
 * @extends Extension<Employee>
 */
class EmployeeProfileImageJpgOnlyExtension extends Extension
{
    public function updateCMSFields(FieldList $fields)
    {
        /** @var UploadField $field */
        $field = $fields->dataFieldByName('ProfileImage');
        $field->setAllowedExtensions(['jpg']);
    }
}
