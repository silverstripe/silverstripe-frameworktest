<?php

class RelationFieldsTestPage extends TestPage
{
    
    private static $has_one = array(
        "HasOneCompany" => "Company",
        "HasOnePage" => "SiteTree",
        "HasOnePageWithSearch" => "SiteTree",
    );
    private static $has_many = array(
        "HasManyCompanies" => "Company",
        "HasManyPages" => "SiteTree",
    );
    private static $many_many = array(
        "ManyManyCompanies" => "Company",
        "ManyManyPages" => "SiteTree",
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
            TreeDropdownField::create('HasOnePageID', 'HasOnePage', 'SiteTree'),
            TreeDropdownField::create('HasOnePageWithSearchID', 'HasOnePageWithSearch', 'SiteTree')->setShowSearch(true),
            TreeMultiselectField::create('HasManyPages', 'HasManyPages', 'SiteTree'),
            TreeMultiselectField::create('ManyManyPages', 'ManyManyPages (with search)', 'SiteTree')->setShowSearch(true)
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
