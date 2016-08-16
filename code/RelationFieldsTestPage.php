<?php

use SilverStripe\FrameworkTest\Model\TestCategory;
use SilverStripe\FrameworkTest\Model\TestPage;
use SilverStripe\FrameworkTest\Model\TestPage_Controller;

class RelationFieldsTestPage extends TestPage
{

    private static $has_one = array(
        "HasOneCompany" => "SilverStripe\\FrameworkTest\\Model\\Company",
        "HasOnePage" => "SilverStripe\\CMS\\Model\\SiteTree",
        "HasOnePageWithSearch" => "SilverStripe\\CMS\\Model\\SiteTree",
    );
    private static $has_many = array(
        "HasManyCompanies" => "SilverStripe\\FrameworkTest\\Model\\Company",
        "HasManyPages" => "SilverStripe\\CMS\\Model\\SiteTree",
    );
    private static $many_many = array(
        "ManyManyCompanies" => "SilverStripe\\FrameworkTest\\Model\\Company",
        "ManyManyPages" => "SilverStripe\\CMS\\Model\\SiteTree",
    );

    private static $defaults = array(
        'Title' => 'Relational Fields'
    );
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $allFields = array();
        
        $checkboxFields = array(
            new CheckboxSetField("CheckboxSet", "CheckboxSetField", TestCategory::map())
        );
        $fields->addFieldsToTab("Root.CheckboxSet", $checkboxFields);
        $allFields += $checkboxFields;

        $treeFields = array(
            TreeDropdownField::create('HasOnePageID', 'HasOnePage', 'SilverStripe\\CMS\\Model\\SiteTree'),
            TreeDropdownField::create('HasOnePageWithSearchID', 'HasOnePageWithSearch', 'SilverStripe\\CMS\\Model\\SiteTree')->setShowSearch(true),
            TreeMultiselectField::create('HasManyPages', 'HasManyPages', 'SilverStripe\\CMS\\Model\\SiteTree'),
            TreeMultiselectField::create('ManyManyPages', 'ManyManyPages (with search)', 'SilverStripe\\CMS\\Model\\SiteTree')->setShowSearch(true)
        );
        $fields->addFieldsToTab('Root.Tree', $treeFields);
        $allFields += $treeFields;

        foreach ($allFields as $field) {
            $field
                ->setDescription('This is <strong>bold</strong> help text')
                ->addExtraClass('cms-help');
                // ->addExtraClass('cms-help cms-help-tooltip');
        }

        return $fields;
    }
}

class RelationFieldsTestPage_Controller extends TestPage_Controller
{
}
