<?php

namespace SilverStripe\FrameworkTest\Elemental\Extension;

use SilverStripe\Assets\File;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Forms\CompositeValidator;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;

/**
 * @extends Extension<ElementContent>
 */
class ElementContentExtension extends Extension
{
    private static $db = [
        'MyField' => 'Varchar',
        'MyInt' => 'Int',
    ];

    private static $has_one = [
        'MyPage' => SiteTree::class,
        'MyFile' => File::class,
    ];

    public function validate(ValidationResult $result)
    {
        if ($this->owner->Title == 'x') {
            $result->addFieldError('Title', 'Title cannot be x');
        }
        if ($this->owner->MyField == 'x') {
            $result->addFieldError('MyField', 'MyField cannot be x');
        }
        if ($this->owner->Title == 'z' && $this->owner->MyField == 'z') {
            $result->addError('This is a general error message');
        }
    }

    public function updateCMSCompositeValidator(CompositeValidator $compositeValidator)
    {
        $compositeValidator->addValidator(new RequiredFields(['Title', 'MyPageID', 'MyFile']));
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('HTML');
        $fields->addFieldToTab('Root.Main', TextField::create('MyField', 'My Field'));
        $fields->addFieldToTab('Root.Main', NumericField::create('MyInt', 'My Int'));
    }
}
