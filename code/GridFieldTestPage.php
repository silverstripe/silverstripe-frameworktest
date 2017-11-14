<?php

use SilverStripe\ORM\DataList;
use SilverStripe\FrameworkTest\Model\TestPage;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;

class GridFieldTestPage extends TestPage
{

    private static $has_one = array(
        "HasOneCompany" => "SilverStripe\\FrameworkTest\\Model\\Company",
    );

    private static $has_many = array(
        "HasManyCompanies" => "SilverStripe\\FrameworkTest\\Model\\Company",
    );

    private static $many_many = array(
        "ManyManyCompanies" => "SilverStripe\\FrameworkTest\\Model\\Company",
    );

    private static $owns = [
        'HasOneCompany',
        'HasManyCompanies',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $grids = array();

        $config = new GridFieldConfig_RecordEditor();
        $grid = new GridField('Companies', 'Companies', new DataList('SilverStripe\\FrameworkTest\\Model\\Company'), $config);
        $grid->setDescription('Records are NOT owned by the page, and need to be individually published');
        $fields->addFieldToTab('Root.NoRelation', $grid);
        $grids[] = $grid;

        $config = new GridFieldConfig_RelationEditor();
        $grid = new GridField('HasManyCompanies', 'HasManyCompanies', $this->HasManyCompanies(), $config);
        $grid->setDescription('Records are owned by the page, so should auto-publish');
        $fields->addFieldToTab('Root.HasMany', $grid);
        $grids[] = $grid;

        $config = new GridFieldConfig_RelationEditor();
        $grid = new GridField('ManyManyCompanies', 'ManyManyCompanies', $this->ManyManyCompanies(), $config);
        $grid->setDescription('Records are NOT owned by the page, and need to be individually published');
        $fields->addFieldToTab('Root.ManyMany', $grid);
        $grids[] = $grid;

        return $fields;
    }
}

class GridFieldTestPage_Controller extends PageController
{

    private static $allowed_actions = array(
        'Form',
    );

    /**
     *
     * @var string
     */
    public $Title = "GridFieldTestPage";

    public function init()
    {
        parent::init();
        Requirements::css('silverstripe/frameworktest: css/gridfieldtest.css', 'screen');
    }

    /**
     *
     * @return Form
     */
    public function Form()
    {
        $config = new GridFieldConfig_RecordEditor();

        $grid = new GridField('Companies', 'Companies', new DataList('SilverStripe\\FrameworkTest\\Model\\Company'), $config);
        return new Form($this, 'Form', new FieldList($grid), new FieldList());
    }
}
