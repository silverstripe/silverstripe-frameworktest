<?php

namespace SilverStripe\FrameworkTest\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\FrameworkTest\Model\Company;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;

/**
 * @extends Extension<Company>
 */
class CompanyGroupPhotoJpgOnlyExtension extends Extension
{
    public function updateCMSFields(FieldList $fields)
    {
        /** @var UploadField $field */
        $field = $fields->dataFieldByName('GroupPhotos');
        $field->setAllowedExtensions(['jpg']);
    }
}
