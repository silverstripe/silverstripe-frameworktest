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
use SilverStripe\Forms\SearchableDropdownField;
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

    protected function updateCMSCompositeValidator(CompositeValidator $compositeValidator)
    {
        $compositeValidator->addValidator(new RequiredFields(['Title', 'MyPageID', 'MyFile']));
    }

    protected function updateCMSFields(FieldList $fields)
    {
        // Note we explicitly use a SearchableDropdownField here so the behat test can rely on specific selectors
        $fields->removeByName(['HTML', 'MyPage', 'MyPageID']);
        $fields->addFieldToTab(
            'Root.Main',
            SearchableDropdownField::create('MyPageID', 'My page', SiteTree::get())->setIsLazyLoaded(false)
        );
        $fields->addFieldToTab('Root.Main', TextField::create('MyField', 'My Field'));
        $fields->addFieldToTab('Root.Main', NumericField::create('MyInt', 'My Int'));
    }
}
