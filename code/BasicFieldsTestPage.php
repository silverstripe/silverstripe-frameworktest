<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\FrameworkTest\Model\TestCategory;
use SilverStripe\FrameworkTest\Model\TestPage;
use SilverStripe\FrameworkTest\Model\TestPage_Controller;
use SilverStripe\Core\Object;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\SelectionGroup_Item;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\AssetField;
use SilverStripe\Forms\UploadField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\RequiredFields;


class BasicFieldsTestPage extends TestPage
{
    private static $db = array(
        'Required' => 'Text',
        'Validated' => 'Text',
        'Checkbox' => 'Boolean',
        'Readonly' => 'Varchar',
        'Textarea' => 'Text',
        'Text' => 'Varchar',
        'CalendarDate' => 'Date',
        'CompositeDate' => 'Date',
        'Date' => 'Date',
        'DMYCalendarDate' => 'Date',
        'DMYDate' => 'Date',
        'DateTime' => 'Datetime',
        'DateTimeWithCalendar' => 'Datetime',
        'Time' => 'Time',

        'Money' => 'Money',
        'Number' => 'Int',
        'Price' => 'Double',
        'Email' => 'Varchar',
        'Password' => 'Varchar',
        'ConfirmedPassword' => 'Varchar',
        'HTMLField' => 'HTMLText',
        'HTMLOneLine' => 'HTMLVarchar',
        'UniqueText' => 'Varchar',
        'AjaxUniqueText' => 'Varchar',
        'UniqueRestrictedText' => 'Varchar',
        'BankNumber' => 'Varchar',
        'PhoneNumber' => 'Varchar',
        'Autocomplete' => 'Varchar',
        'CreditCard' => 'Varchar',
        'GSTNumber' => 'Varchar',
        'OptionSet' => 'Int',
        'DBFile' => 'DBFile',
    );

    private static $has_one = array(
        'Dropdown' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
        'GroupedDropdown' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
        'File' => 'SilverStripe\\Assets\\File',
        'AttachedFile' => 'SilverStripe\\Assets\\File',
        'Image' => 'SilverStripe\\Assets\\Image',
    );

    private static $has_many = array(
        'HasManyFiles' => 'SilverStripe\\Assets\\File',
    );

    private static $many_many = array(
        'ManyManyFiles' => 'SilverStripe\\Assets\\File',
        'MultipleListboxField' => 'SilverStripe\\FrameworkTest\\Model\\TestCategory',
    );

    private static $defaults = array(
        'Validated' => 2
    );

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        if ($inst = DataObject::get_one('BasicFieldsTestPage')) {
            $data = $this->getDefaultData();
            $inst->update($data);
            $inst->write();
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
            'Readonly' => 'My value (ä!)',
            'Textarea' => 'My value (ä!)',
            'Required' => 'My required value (delete to test)',
            'Validated' => '1',
            'Text' => 'My value (ä!)',
            'Textarea' => 'My value (ä!)',
            'HTMLField' => 'My value (ä!)',
            'Email' => 'test@test.com',
            'Password' => 'My value (ä!)',
            'Number' => 99,
            'Price' => 99.99,
            'MoneyAmount' => 99.99,
            'MoneyCurrency' => 'EUR',
            'PhoneNumber' => '021 1235',
            'CreditCard' => '4000400040004111',
            'Checkbox' => 1,
            'CheckboxSetID' => $firstCat->ID,
            'DropdownID' => $firstCat->ID,
            'GroupedDropdownID' => $firstCat->ID,
            'MultipleListboxFieldID' => join(',', array($thirdCat->ID, $firstCat->ID)),
            'OptionSet' => join(',', array($thirdCat->ID, $firstCat->ID)),
            'Date' => "2002-10-23",
            'CalendarDate' => "2002-10-23",
            'DMYDate' => "2002-10-23",
            'Time' => "23:59",
            'DateTime' => "2002-10-23 23:59",
            'DateTimeWithCalendar' => "2002-10-23 23:59",
            'MyFieldGroup1' => 'My value (ä!)',
            'MyFieldGroup2' => 'My value (ä!)',
            'MyFieldGroup3' => 'My value (ä!)',
            'MyFieldGroupCheckbox' => true,
            'MyCompositeField1' => 'My value (ä!)',
            'MyCompositeField2' => 'My value (ä!)',
            'MyCompositeField3' => 'My value (ä!)',
            'MyCompositeFieldCheckbox' => true,
        );
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $description = 'This is <strong>bold</strong> help text';
        $rightTitle = 'This is right title';

        $fields->addFieldsToTab('Root.Text', array(
            Object::create('SilverStripe\\Forms\\TextField', 'Required', 'Required field')
                ->setRightTitle('right title'),
            Object::create('SilverStripe\\Forms\\TextField', 'Validated', 'Validated field (checks range between 1 and 3)'),
            Object::create('SilverStripe\\Forms\\ReadonlyField', 'Readonly', 'SilverStripe\\Forms\\ReadonlyField'),
            Object::create('SilverStripe\\Forms\\TextareaField', 'Textarea', 'TextareaField - 8 rows')
                ->setRows(8),
            Object::create('SilverStripe\\Forms\\TextField', 'Text', 'SilverStripe\\Forms\\TextField'),
            Object::create('SilverStripe\\Forms\\HTMLEditor\\HTMLEditorField', 'HTMLField', 'HtmlEditorField'),
            Object::create('SilverStripe\\Forms\\EmailField', 'SilverStripe\\Control\\Email\\Email', 'SilverStripe\\Forms\\EmailField'),
            Object::create('SilverStripe\\Forms\\PasswordField', 'Password', 'SilverStripe\\Forms\\PasswordField'),
            Object::create('SilverStripe\\Forms\\ConfirmedPasswordField', 'SilverStripe\\Forms\\ConfirmedPasswordField', 'SilverStripe\\Forms\\ConfirmedPasswordField')
        ));

        $fields->addFieldsToTab('Root.Numeric', array(
            Object::create('SilverStripe\\Forms\\NumericField', 'Number', 'SilverStripe\\Forms\\NumericField'),
            Object::create('SilverStripe\\Forms\\CurrencyField', 'Price', 'SilverStripe\\Forms\\CurrencyField'),
            Object::create('SilverStripe\\Forms\\MoneyField', 'Money', 'SilverStripe\\Forms\\MoneyField', array('Amount' => 99.99, 'Currency' => 'EUR')),
            Object::create('SilverStripe\\Forms\\PhoneNumberField', 'PhoneNumber', 'SilverStripe\\Forms\\PhoneNumberField'),
            Object::create('SilverStripe\\Forms\\CreditCardField', 'CreditCard', 'SilverStripe\\Forms\\CreditCardField')
        ));

        $fields->addFieldsToTab('Root.Option', array(
            Object::create('SilverStripe\\Forms\\CheckboxField', 'Checkbox', 'SilverStripe\\Forms\\CheckboxField'),
            Object::create('SilverStripe\\Forms\\CheckboxSetField', 'CheckboxSet', 'SilverStripe\\Forms\\CheckboxSetField', TestCategory::map()),
            Object::create('SilverStripe\\Forms\\DropdownField', 'DropdownID', 'SilverStripe\\Forms\\DropdownField', TestCategory::map())
                ->setHasEmptyDefault(true),
            Object::create('SilverStripe\\Forms\\GroupedDropdownField', 'GroupedDropdownID',
                'GroupedDropdown', array('Test Categorys' => TestCategory::map())
            ),
            Object::create('SilverStripe\\Forms\\ListboxField', 'MultipleListboxFieldID', 'ListboxField (multiple)', TestCategory::map())
                ->setSize(3),
            Object::create('SilverStripe\\Forms\\OptionsetField', 'OptionSet', 'OptionSetField', TestCategory::map()),
            Object::create('SilverStripe\\Forms\\SelectionGroup', 'SilverStripe\\Forms\\SelectionGroup', array(
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
            )),
            Object::create('SilverStripe\\Forms\\ToggleCompositeField', 'SilverStripe\\Forms\\ToggleCompositeField', 'SilverStripe\\Forms\\ToggleCompositeField', new FieldList(
                Object::create('SilverStripe\\Forms\\TextField', 'ToggleCompositeTextField1'),
                Object::create('SilverStripe\\Forms\\TextField', 'ToggleCompositeTextField2'),
                Object::create('SilverStripe\\Forms\\DropdownField', 'ToggleCompositeDropdownField', 'ToggleCompositeDropdownField', TestCategory::map()),
                Object::create('SilverStripe\\Forms\\TextField', 'ToggleCompositeTextField3')
            ))
        ));

        // All these date/time fields generally have issues saving directly in the CMS
        $fields->addFieldsToTab('Root.DateTime', array(
            $calendarDateField = Object::create('SilverStripe\\Forms\\DateField', 'CalendarDate', 'DateField with calendar'),
            Object::create('SilverStripe\\Forms\\DateField', 'Date', 'SilverStripe\\Forms\\DateField'),
            $dmyDateField = Object::create('SilverStripe\\Forms\\DateField', 'DMYDate', 'DateField with separate fields'),
            Object::create('SilverStripe\\Forms\\TimeField', 'Time', 'SilverStripe\\Forms\\TimeField'),
            Object::create('SilverStripe\\Forms\\DatetimeField', 'DateTime', 'DateTime'),
            $dateTimeShowCalendar = Object::create('SilverStripe\\Forms\\DatetimeField', 'DateTimeWithCalendar', 'DateTime with calendar')
        ));
        $calendarDateField->setConfig('showcalendar', true);
        $dmyDateField->setConfig('dmyfields', true);
        $dateTimeShowCalendar->getDateField()->setConfig('showcalendar', true);
        $dateTimeShowCalendar->getTimeField()->setConfig('showdropdown', true);
        $dateTimeShowCalendar->setRightTitle('Right title');

        $fields->addFieldsToTab('Root.File', array(
            AssetField::create('DBFile'),
            $bla = UploadField::create('File', 'FileUploadField')
                ->setDescription($description)
                ->setRightTitle($rightTitle)
                ->setConfig('allowedMaxFileNumber', 1)
                ->setConfig('canPreviewFolder', false),
            UploadField::create('AttachedFile', 'UploadField with canUpload=false')
                ->setDescription($description)
                ->setRightTitle($rightTitle)
                ->setConfig('canUpload', false),
            UploadField::create('Image', 'UploadField for image')
                ->setDescription($description)
                ->setRightTitle($rightTitle),
            UploadField::create('HasManyFiles', 'UploadField for has_many')
                ->setRightTitle($rightTitle)
                ->setDescription($description),
            UploadField::create('ManyManyFiles', 'UploadField for many_many')
                ->setDescription($description)
                ->setRightTitle($rightTitle),
        ));

        $data = $this->getDefaultData();
        foreach ($fields->dataFields() as $field) {
            $name = $field->getName();
            if (isset($data[$name])) {
                $field->setValue($data[$name]);
            }
        }

        $blacklist = array(
            'DMYDate', 'Required', 'Validated', 'SilverStripe\\Forms\\ToggleCompositeField', 'SilverStripe\\Forms\\SelectionGroup'
        );

        $tabs = array('Root.Text', 'Root.Numeric', 'Root.Option', 'Root.DateTime', 'Root.File');
        foreach ($tabs as $tab) {
            $tabObj = $fields->fieldByName($tab);
            foreach ($tabObj->FieldList() as $field) {
                $field
                    ->setDescription($description)
                    ->setRightTitle($rightTitle);
                    // ->addExtraClass('cms-description-tooltip');

                if (in_array($field->getName(), $blacklist)) {
                    continue;
                }

                $disabledField = $field->performDisabledTransformation();
                $disabledField->setTitle($disabledField->Title() . ' (disabled)');
                $disabledField->setName($disabledField->getName() . '_disabled');
                $tabObj->insertAfter($disabledField, $field->getName());

                $readonlyField = $field->performReadonlyTransformation();
                $readonlyField->setTitle($readonlyField->Title() . ' (readonly)');
                $readonlyField->setName($readonlyField->getName() . '_readonly');
                $tabObj->insertAfter($readonlyField, $field->getName());
            }
        }

        $noLabelField = new TextField('Text_NoLabel', false, 'TextField without label');
        $noLabelField->setDescription($description);
        $noLabelField->setRightTitle($rightTitle);
        $fields->addFieldToTab('Root.Text', $noLabelField, 'Text_disabled');

        $fields->addFieldToTab('Root.Text',
            LabelField::create('SilverStripe\\Forms\\LabelField', 'SilverStripe\\Forms\\LabelField')
        );

        $fields->addFieldToTab('Root.Text',
            LiteralField::create('SilverStripe\\Forms\\LiteralField', '<div class="form__divider">LiteralField with <b>some bold text</b> and <a href="http://silverstripe.com">a link</a></div>')
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
    public function AutoCompleteItems()
    {
        $items = array(
            'TestItem1',
            'TestItem2',
            'TestItem3',
            'TestItem4',
        );
        return implode(',', $items);
    }
}
