<?php

class BasicFieldsTestPage extends TestPage {
	static $db = array(
		'Checkbox' => 'Boolean',
		'Readonly' => 'Varchar',
		'Textarea' => 'Text',
		'Text' => 'Varchar',
		'CalendarDate' => 'Date',
		'CompositeDate' => 'Date',
		'Date' => 'Date',
		"DateDisabled" => "Date",
		'TimeDisabled' => 'Time',
		'DateTimeDisabled' => 'Datetime',
		'DMYCalendarDate' => 'Date',
		'DMYDate' => 'Date',
		'DateTime' => 'Datetime',
		'DateTimeWithCalendar' => 'Datetime',
		'Time' => 'Time',
		'TimeWithDropdown' => 'Time',
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
	);
	
	static $has_one = array(
		'Dropdown' => 'TestCategory',
		'OptionSet' => 'TestCategory',
		'GroupedDropdown' => 'TestCategory',
		'ListboxField' => 'TestCategory',
		'File' => 'File',
		'Image' => 'Image',
	);

	static $has_many = array(
		'HasManyFiles' => 'File',
	);

	static $many_many = array(
		'ManyManyFiles' => 'File',
	);
	
	static $defaults = array(
		'Readonly' => 'Default value for \'readonly\'',
		"DateDisabled" => "2002-10-23",
		"DateTimeDisabled" => "2002-10-23 23:59",
		"TimeDisabled" => "23:59",
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldsToTab('Root.Text', array(
			new ReadonlyField('Readonly', 'ReadonlyField'),
			new TextareaField('Textarea', 'TextareaField - 8 rows', 8),
			new TextField('Text', 'TextField'),
			new HtmlEditorField('HTMLField', 'HtmlEditorField'),
			new EmailField('Email', 'EmailField'),
			new PasswordField('Password', 'PasswordField'),
			new AjaxUniqueTextField('AjaxUniqueText', 'AjaxUniqueTextField', 'AjaxUniqueText', 'BasicFieldsTestPage'),
		));
		
		$fields->addFieldsToTab('Root.Numeric', array(
			new NumericField('Number', 'NumericField'),
			new CurrencyField('Price', 'CurrencyField'),
			new PhoneNumberField('PhoneNumber', 'PhoneNumberField'),
			new CreditCardField('CreditCard', 'CreditCardField')
		));
		
		$fields->addFieldsToTab('Root.Option', array(
			new CheckboxField('Checkbox', 'CheckboxField'),
			new CheckboxSetField('CheckboxSet', 'CheckboxSetField', TestCategory::map()),
			new DropdownField('DropdownID', 'DropdownField', TestCategory::map()),
			new GroupedDropdownField('GroupedDropdownID', 'GroupedDropdown', array('Test Categorys' => TestCategory::map())),
			new ListboxField('ListboxFieldID', 'ListboxField', TestCategory::map(), array(), 3),
			new OptionsetField('OptionSetID', 'OptionSetField', TestCategory::map()),
		));

		// All these date/time fields generally have issues saving directly in the CMS
		$fields->addFieldsToTab('Root.DateTime', array(
			$calendarDateField = new DateField('CalendarDate','DateField with calendar'),
			new DateField('Date','DateField'),
			$dmyDateField = new DateField('DMYDate','DateField with separate fields'),
			new TimeField('Time','TimeField'),
			$timeFieldDropdown = new TimeField('TimeDropdown','TimeField with dropdown'),
			new DatetimeField('DateTime', 'DateTime'),
			$dateTimeShowCalendar = new DatetimeField('DateTimeWithCalendar', 'DateTime with calendar')
		));
		$calendarDateField->setConfig('showcalendar', true);
		$dmyDateField->setConfig('dmyfields', true);
		$timeFieldDropdown->setConfig('showdropdown', true);
		$dateTimeShowCalendar->getDateField()->setConfig('showcalendar', true);
		$dateTimeShowCalendar->getTimeField()->setConfig('showdropdown', true);

		$fields->addFieldsToTab('Root.File', array(
			UploadField::create('File','FileUploadField'),
			UploadField::create('Image','ImageUploadField'),
			UploadField::create('HasManyFiles','HasManyFilesUploadField'),
			UploadField::create('ManyManyFiles','ManyManyFilesUploadField')
		));

		$tabs = array('Root.Text', 'Root.Numeric', 'Root.Option', 'Root.DateTime', 'Root.File');
		foreach($tabs as $tab) {
			$tabObj = $fields->fieldByName($tab);
			foreach($tabObj->FieldList() as $field) {
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

		$fields->addFieldToTab('Root.Text', new TextField('Text_NoLabel', false, 'TextField without label'), 'Text_disabled');

		return $fields;

	}
}

class BasicFieldsTestPage_Controller extends TestPage_Controller {
	function AutoCompleteItems() {
		$items = array(
			'TestItem1',
			'TestItem2',
			'TestItem3',
			'TestItem4',
		);
		return implode(',', $items);
	}
}

?>
