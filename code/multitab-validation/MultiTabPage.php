<?php

namespace SilverStripe\FrameworkTest\Model;

use Page;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;

if (!class_exists(Page::class)) {
    return;
}

/**
 * This class is specifically for the silverstripe/admin behat test multitab-validation.feature
 */
class MultiTabPage extends Page
{
    private static $table_name = 'MultiTabPage';

    private static $db = [
        'SecondTabFirstField' => 'Varchar(50)',
        'ThirdTabFirstField' => 'Varchar(50)',
        'ThirdTabSecondField' => 'Varchar(50)',
        'FourthTabFirstField' => 'Varchar(50)',
        'SettingsTabFirstField' => 'Varchar(50)',
    ];

    private static array $scaffold_cms_fields_settings = [
        'ignoreFields' => [
            'SettingsTabFirstField',
        ],
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Second", TextField::create("SecondTabFirstField"));
        $fields->addFieldToTab("Root.Third", EmailField::create("ThirdTabFirstField"));
        $fields->addFieldToTab("Root.Third", TextField::create("ThirdTabSecondField"));
        $fields->addFieldToTab("Root.Fourth", TextField::create("FourthTabFirstField"));
        return $fields;
    }

    public function getSettingsFields()
    {
        $fields = parent::getSettingsFields();
        $fields->addFieldToTab("Root.Settings", TextField::create('SettingsTabFirstField'));
        return $fields;
    }

    public function getCMSValidator()
    {
        return new RequiredFields([
            'ThirdTabFirstField',
            'FourthTabFirstField',
            // This is only validated if you are actually on the settings tab when clicking save
            'SettingsTabFirstField'
        ]);
    }

    public function validate()
    {
        $result = parent::validate();

        // Validation error on specific form field that is not in RequiredFields
        if ($this->SecondTabFirstField && $this->SecondTabFirstField !== '222') {
            $result->addFieldError('SecondTabFirstField', 'Value of field must be 222');
        }

        // Manual testing only, uncomment this line to test
        // $result->addError('This page cannot exist.');

        return $result;
    }
}
