<?php

use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\GroupedDropdownField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\MoneyField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\SelectionGroup;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TimeField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataObject;
use SilverStripe\FrameworkTest\Model\TestCategory;
use SilverStripe\FrameworkTest\Model\TestPage;
use SilverStripe\FrameworkTest\Model\TestPage_Controller;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\SelectionGroup_Item;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\HTMLReadonlyField;

class BasicFieldsTestPage extends TestPage
{
    private static $table_name = 'BasicFieldsTestPage';

    private static $db = array(
        'CalendarDate' => 'Date',
        'Checkbox' => 'Boolean',
        'Date' => 'Date',
        'DateTime' => 'Datetime',
        'DateTimeWithCalendar' => 'Datetime',
        'DBFile' => 'DBFile',
        'Email' => 'Varchar',
        'HTMLField' => 'HTMLText',
        'Money' => 'Money',
        'MyCompositeField1' => 'Varchar',
        'MyCompositeField2' => 'Varchar',
        'MyCompositeField3' => 'Varchar',
        'MyCompositeFieldCheckbox' => 'Boolean',
        'MyFieldGroup1' => 'Varchar',
        'MyFieldGroup2' => 'Varchar',
        'MyFieldGroup3' => 'Varchar',
        'MyFieldGroupCheckbox' => 'Boolean',
        'MyLabelledFieldGroup1' => 'Varchar',
        'MyLabelledFieldGroup2' => 'Varchar',
        'MyLabelledFieldGroup3' => 'Int',
        'MyLabelledFieldGroupCheckbox' => 'Boolean',
        'Number' => 'Float',
        'OptionSet' => 'Varchar',
        'Price' => 'Double',
        'Readonly' => 'Varchar',
        'Required' => 'Text',
        'Text' => 'Varchar',
        'Textarea' => 'Text',
        'Time' => 'Time',
        'TimeHTML5' => 'Time',
        'ToggleCompositeTextField1' => 'Varchar',
        'ToggleCompositeDropdownField' => 'Varchar',
        'Validated' => 'Int',
    );

    private static $has_one = array(
        'Dropdown' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
        'GroupedDropdown' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
        'Image' => 'SilverStripe\\Assets\\Image',
    );

    private static $has_many = array(
        'HasManyFiles' => 'SilverStripe\\Assets\\File',
    );

    private static $many_many = array(
        'ManyManyFiles' => 'SilverStripe\\Assets\\File',
        'CheckboxSet' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
        'Listbox' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
    );

    private static $owns = [
        'Image',
    ];

    private static array $scaffold_cms_fields_settings = [
        'ignoreFields' => [
            'MyCompositeField1',
            'MyCompositeField2',
            'MyCompositeField3',
            'MyCompositeFieldCheckbox',
            'MyFieldGroup1',
            'MyFieldGroup2',
            'MyFieldGroup3',
            'MyFieldGroupCheckbox',
            'MyLabelledFieldGroup1',
            'MyLabelledFieldGroup2',
            'MyLabelledFieldGroup3',
            'MyLabelledFieldGroupCheckbox',
            'ToggleCompositeTextField1',
            'ToggleCompositeDropdownField',
        ],
        'ignoreRelations' => [
            'CheckboxSet',
            'Listbox',
        ],
    ];

    private static $defaults = array(
        'Validated' => 2
    );

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        if ($inst = DataObject::get_one('BasicFieldsTestPage') && static::config()->get('regenerate_on_build')) {
            $data = $this->getDefaultData();
            $inst->update($data);
            $inst->write();
            TestCategory::create()->requireDefaultRecords();
            $cats = TestCategory::get();
            $firstCat = $cats->offsetGet(0);
            $thirdCat = $cats->offsetGet(2);
            $inst->Listbox()->add($firstCat);
            $inst->Listbox()->add($thirdCat);
            $inst->CheckboxSet()->add($firstCat);
            $inst->CheckboxSet()->add($thirdCat);

        }
    }

    public function getDefaultData()
    {
        $cats = TestCategory::get();
        if (!$cats->Count()) {
            return array();
        } // not initialized yet

        $firstCat = $cats->offsetGet(0);
        $thirdCat = $cats->offsetGet(2);

        return array(
            'CalendarDate' => "2017-01-31",
            'Checkbox' => 1,
            // 'CheckboxSet' => null,
            'Date' => "2017-01-31",
            'DateTime' => "2017-01-31 23:59",
            'DateTimeWithCalendar' => "2017-01-31 23:59",
            'DropdownID' => $firstCat->ID,
            'Email' => 'test@test.com',
            'GroupedDropdownID' => $firstCat->ID,
            'HTMLField' => 'My <strong>value</strong> (ä!)',
            'MoneyAmount' => 99.99,
            'MoneyCurrency' => 'EUR',
            // 'ListboxID' => null,
            'MyCompositeField1' => 'My value (ä!)',
            'MyCompositeField2' => 'My value (ä!)',
            'MyCompositeField3' => 'My value (ä!)',
            'MyCompositeFieldCheckbox' => true,
            'MyFieldGroup1' => 'My value (ä!)',
            'MyFieldGroup2' => 'My value (ä!)',
            'MyFieldGroup3' => 'My value (ä!)',
            'MyFieldGroupCheckbox' => true,
            'MyLabelledFieldGroup1' => 'My value (ä!)',
            'MyLabelledFieldGroup2' => 'My value (ä!)',
            'MyLabelledFieldGroup3' => 2,
            'MyLabelledFieldGroupCheckbox' => true,
            'Number' => 99.123,
            'OptionSet' => $thirdCat->ID,
            'Price' => 99.99,
            'Readonly' => 'My value (ä!)',
            'Required' => 'My required value (delete to test)',
            'Text' => 'My value (ä!)',
            'Textarea' => 'My value (ä!)',
            'Time' => "23:59",
            'TimeHTML5' => "23:59",
            'ToggleCompositeTextField1' => 'My value (ä!)',
            'Validated' => 1,
        );
    }

    public function Listbox_readonly() {
        return $this->Listbox();
    }

    public function Listbox_disabled() {
        return $this->Listbox();
    }

    public function CheckboxSet_readonly() {
        return $this->CheckboxSet();
    }

    public function CheckboxSet_disabled() {
        return $this->CheckboxSet();
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $description = 'This is <strong>bold</strong> help text';
        $rightTitle = 'This is right title';

        $fields->addFieldsToTab('Root.Text', [
            Injector::inst()->create(TextField::class, 'Required', 'Required field')
                ->setRightTitle('right title'),
            Injector::inst()->create(TextField::class, 'Validated', 'Validated field (checks range between 1 and 3)'),
            Injector::inst()->create(ReadonlyField::class, 'Readonly', 'ReadonlyField'),
            Injector::inst()->create(TextareaField::class, 'Textarea', 'TextareaField - 8 rows')
                ->setRows(8),
            Injector::inst()->create(TextField::class, 'Text'),
            Injector::inst()->create(HTMLEditorField::class, 'HTMLField', 'HTMLField'),
            Injector::inst()->create(EmailField::class, 'Email'),
        ]);

        $fields->addFieldsToTab('Root.Numeric', array(
            Injector::inst()->create(NumericField::class, 'Number')
                ->setScale(4),
            Injector::inst()->create(CurrencyField::class, 'Price'),
            Injector::inst()->create(MoneyField::class, 'Money', 'Money', array('Amount' => 99.99, 'Currency' => 'EUR'))
        ));

        $fields->addFieldsToTab('Root.Option', array(
            Injector::inst()->create(CheckboxField::class, 'Checkbox'),
            Injector::inst()->create(CheckboxSetField::class, 'CheckboxSet', 'CheckboxSet', TestCategory::map()),
            Injector::inst()->create(DropdownField::class, 'DropdownID', 'DropdownField', TestCategory::map())
                ->setHasEmptyDefault(true),
            Injector::inst()->create(
                GroupedDropdownField::class,
                'GroupedDropdownID',
                'GroupedDropdown',
                array('Test Categories' => TestCategory::map())
            ),
            Injector::inst()->create(ListboxField::class, 'Listbox', 'ListboxField (multiple)', TestCategory::map())
                ->setSize(3),
            Injector::inst()->create(OptionsetField::class, 'OptionSet', 'OptionSetField', TestCategory::map()),
            Injector::inst()->create(
                SelectionGroup::class,
                'SelectionGroup',
                [
                    new SelectionGroup_Item(
                        'one',
                        TextField::create('SelectionGroupOne', 'one view'),
                        'SelectionGroup Option One'
                    ),
                    new SelectionGroup_Item(
                        'two',
                        TextField::create('SelectionGroupOneTwo', 'two view'),
                        'SelectionGroup Option Two'
                    )
                ]
            ),
            Injector::inst()->create(ToggleCompositeField::class, 'ToggleCompositeField', 'ToggleCompositeField', new FieldList(
                Injector::inst()->create(TextField::class, 'ToggleCompositeTextField1'),
                Injector::inst()->create(DropdownField::class, 'ToggleCompositeDropdownField', 'ToggleCompositeDropdownField', TestCategory::map())
            ))
        ));

        $minDate = '2017-01-01';
        $minDateTime = '2017-01-01 23:59:00';
        $fields->addFieldsToTab('Root.DateTime', array(
            Injector::inst()->create(DateField::class, 'CalendarDate', 'DateField with HTML5 (min date: ' . $minDate . ')')
                ->setMinDate($minDate),
            Injector::inst()->create(DateField::class, 'Date', 'DateField without HTML5 (min date: ' . $minDate . ')')
                ->setHTML5(false)
                ->setMinDate($minDate),
            Injector::inst()->create(TimeField::class, 'Time', 'TimeField without HTML5')
                ->setHTML5(false),
            Injector::inst()->create(TimeField::class, 'TimeHTML5', 'TimeField with HTML5'),
            Injector::inst()->create(DatetimeField::class, 'DateTime', 'DateTime without HTML5 (min date/time: ' . $minDateTime . ')')
                ->setHTML5(false)
                ->setMinDatetime($minDateTime),
            Injector::inst()->create(DatetimeField::class, 'DateTimeWithCalendar', 'DateTime with HTML5 (min date/time: ' . $minDateTime . ')')
                ->setMinDatetime($minDateTime),
        ));

        $fields->addFieldsToTab('Root.File', array(
            $bla = UploadField::create('File', 'UploadField with multiUpload=false (owned by page)')
                ->setDescription($description)
                ->setRightTitle($rightTitle)
                ->setIsMultiUpload(false),
            UploadField::create('Image', 'UploadField for image (owned by page)')
                ->setDescription($description)
                ->setRightTitle($rightTitle),
            UploadField::create('HasManyFiles', 'UploadField for has_many')
                ->setRightTitle($rightTitle)
                ->setDescription($description),
            UploadField::create('ManyManyFiles', 'UploadField for many_many')
                ->setDescription($description)
                ->setRightTitle($rightTitle),
        ));

        $blacklist = array(
            'Required', 'Validated', 'ToggleCompositeField', 'SelectionGroup'
        );

        $tabs = array('Root.Text', 'Root.Numeric', 'Root.Option', 'Root.DateTime', 'Root.File');
        foreach ($tabs as $tab) {
            $tabObj = $fields->fieldByName($tab);
            foreach ($tabObj->FieldList() as $field) {
                $field
                    ->setDescription($description)
                    ->setRightTitle($rightTitle)
                    ->addExtraClass('my-extra-class');

                if (in_array($field->getName(), $blacklist ?? [])) {
                    continue;
                }

                $disabledField = $field->performDisabledTransformation();
                $disabledField->setTitle($disabledField->Title() . ' (disabled)');
                $disabledField->setName($disabledField->getName() . '_disabled');
                $disabledField->setValue($this->getField($field->getName()));
                $tabObj->insertAfter($field->getName(), $disabledField);

                $readonlyField = $field->performReadonlyTransformation();
                $readonlyField->setTitle($readonlyField->Title() . ' (readonly)');
                $readonlyField->setName($readonlyField->getName() . '_readonly');
                $readonlyField->setValue($this->getField($field->getName()));
                $tabObj->insertAfter($field->getName(), $readonlyField);
            }
        }

        $noLabelField = new TextField('Text_NoLabel', false, 'TextField without label');
        $noLabelField->setDescription($description);
        $noLabelField->setRightTitle($rightTitle);
        $fields->addFieldToTab('Root.Text', $noLabelField, 'Text_disabled');

        $fields->addFieldToTab('Root.Text',
            LabelField::create('SilverStripe\\Forms\\LabelField', 'LabelField')
        );

        $fields->addFieldToTab('Root.Text',
            Injector::inst()->create(
                LiteralField::class,
                'LiteralField',
                '<div class="form__divider">LiteralField with <b>some bold text</b> and <a href="http://silverstripe.com">a link</a></div>'
            )
        );

        $fields->addFieldToTab('Root.Text',
            Injector::inst()->create(
                HTMLReadonlyField::class,
                'HTMLReadonlyField',
                'HTMLReadonlyField',
                '<div class="form__divider">HTMLReadonlyField with <b>some bold text</b></div>'
            )
        );

        $fields->addFieldToTab('Root.Text',
            FieldGroup::create(
                TextField::create('MyFieldGroup1'),
                TextField::create('MyFieldGroup2'),
                DropdownField::create('MyFieldGroup3', false, TestCategory::map()),
                CheckboxField::create('MyFieldGroupCheckbox')
            )
                ->setDescription($description)
                ->setRightTitle($rightTitle)
        );
        $fields->addFieldToTab('Root.Text',
            FieldGroup::create(
                'MyLabelledFieldGroup',
                array(
                    TextField::create('MyLabelledFieldGroup1'),
                    TextField::create('MyLabelledFieldGroup2'),
                    DropdownField::create('MyLabelledFieldGroup3', null, TestCategory::map()),
                    CheckboxField::create('MyLabelledFieldGroupCheckbox')
                )
            )
                ->setTitle('My Labelled Field Group')
                ->setDescription($description)
                ->setRightTitle($rightTitle)
        );

        $fields->addFieldToTab('Root.Text',
            CompositeField::create(
                TextField::create('MyCompositeField1'),
                TextField::create('MyCompositeField2'),
                DropdownField::create('MyCompositeField3', 'MyCompositeField3', TestCategory::map()),
                CheckboxField::create('MyCompositeFieldCheckbox')
            )
        );

        return $fields;
    }

    public function getCMSValidator()
    {
        return new RequiredFields('Required');
    }

    public function validate()
    {
        $result = parent::validate();
        if (!$this->Validated || $this->Validated < 1 || $this->Validated > 3) {
            $result->error('"Validated" field needs to be between 1 and 3');
        }
        return $result;
    }
}

class BasicFieldsTestPage_Controller extends TestPage_Controller
{

}
