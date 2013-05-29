<?php

class BasicFieldsTestPage extends TestPage {
	private static $db = array(
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
		'OptionSet' => 'Int',
	);
	
	private static $has_one = array(
		'Dropdown' => 'TestCategory',
		'GroupedDropdown' => 'TestCategory',
		'ListboxField' => 'TestCategory',
		'File' => 'File',
		'AttachedFile' => 'File',
		'Image' => 'Image',
	);

	private static $has_many = array(
		'HasManyFiles' => 'File',
	);

	private static $many_many = array(
		'ManyManyFiles' => 'File',
		'MultipleListboxField' => 'TestCategory',
	);

	function requireDefaultRecords() {
		parent::requireDefaultRecords();

		if($inst = DataObject::get_one('BasicFieldsTestPage')) {
			$data = $this->getDefaultData();
			$inst->update($data);
			$inst->write();
		}
	}

	function getDefaultData() {
		$cats = TestCategory::get();
		if(!$cats->Count()) return array(); // not initialized yet

		$firstCat = $cats->offsetGet(0);
		$thirdCat = $cats->offsetGet(2);

		return array(
			'Readonly' => 'My value (ä!)',
			'Textarea' => 'My value (ä!)',
			'Text' => 'My value (ä!)',
			'Textarea' => 'My value (ä!)',
			'HTMLField' => 'My value (ä!)',
			'Email' => 'test@test.com',
			'Password' => 'My value (ä!)',
			'Number' => 99,
			'Price' => 99.99,
			'PhoneNumber' => '021 1235',
			'CreditCard' => '4000400040004111',
			'Checkbox' => 1,
			'CheckboxSetID' => $firstCat->ID,
			'DropdownID' => $firstCat->ID,
			'GroupedDropdownID' => $firstCat->ID,
			'ListboxFieldID' => $firstCat->ID,
			'MultipleListboxFieldID' => join(',', array($thirdCat->ID, $firstCat->ID)),
			'OptionSet' => join(',', array($thirdCat->ID, $firstCat->ID)),
			'Date' => "2002-10-23",
			'CalendarDate' => "2002-10-23",
			'DMYDate' => "2002-10-23",
			'Time' => "23:59",
			'TimeWithDropdown' => "23:59",
			'DateTime' => "2002-10-23 23:59",
			'DateTimeWithCalendar' => "2002-10-23 23:59",
		);
	}
	
	function getCMSFields() {
		$fields = parent::getCMSFields();

		$description = 'This is <strong>bold</strong> help text';
		
		$fields->addFieldsToTab('Root.Text', array(
			Object::create('ReadonlyField', 'Readonly', 'ReadonlyField'),
			Object::create('TextareaField', 'Textarea', 'TextareaField - 8 rows')
				->setRows(8),
			Object::create('TextField', 'Text', 'TextField'),
			Object::create('HtmlEditorField', 'HTMLField', 'HtmlEditorField'),
			Object::create('EmailField', 'Email', 'EmailField'),
			Object::create('PasswordField', 'Password', 'PasswordField'),
			Object::create('AjaxUniqueTextField', 'AjaxUniqueText', 
				'AjaxUniqueTextField', 'AjaxUniqueText', 'BasicFieldsTestPage'
			)
		));

		$fields->addFieldsToTab('Root.Numeric', array(
			Object::create('NumericField', 'Number', 'NumericField'),
			Object::create('CurrencyField', 'Price', 'CurrencyField'),
			Object::create('PhoneNumberField', 'PhoneNumber', 'PhoneNumberField'),
			Object::create('CreditCardField', 'CreditCard', 'CreditCardField')
		));
		
		$fields->addFieldsToTab('Root.Option', array(
			Object::create('CheckboxField', 'Checkbox', 'CheckboxField'),
			Object::create('CheckboxSetField', 'CheckboxSet', 'CheckboxSetField', TestCategory::map()),
			Object::create('DropdownField', 'DropdownID', 'DropdownField', TestCategory::map())
				->setHasEmptyDefault(true),
			Object::create('GroupedDropdownField', 'GroupedDropdownID', 
				'GroupedDropdown', array('Test Categorys' => TestCategory::map())
			),
			Object::create('ListboxField', 'ListboxFieldID', 'ListboxField', TestCategory::map())
				->setSize(3),
			Object::create('ListboxField', 'MultipleListboxFieldID', 'ListboxField (multiple)', TestCategory::map())
				->setMultiple(true)
				->setSize(3),
			Object::create('OptionsetField', 'OptionSet', 'OptionSetField', TestCategory::map()),
		));

		// All these date/time fields generally have issues saving directly in the CMS
		$fields->addFieldsToTab('Root.DateTime', array(
			$calendarDateField = Object::create('DateField', 'CalendarDate','DateField with calendar'),
			Object::create('DateField', 'Date','DateField'),
			$dmyDateField = Object::create('DateField', 'DMYDate','DateField with separate fields'),
			Object::create('TimeField', 'Time','TimeField'),
			$timeFieldDropdown = Object::create('TimeField', 'TimeWithDropdown','TimeField with dropdown'),
			Object::create('DatetimeField', 'DateTime', 'DateTime'),
			$dateTimeShowCalendar = Object::create('DatetimeField', 'DateTimeWithCalendar', 'DateTime with calendar')
		));
		$calendarDateField->setConfig('showcalendar', true);
		$dmyDateField->setConfig('dmyfields', true);
		$timeFieldDropdown->setConfig('showdropdown', true);
		$dateTimeShowCalendar->getDateField()->setConfig('showcalendar', true);
		$dateTimeShowCalendar->getTimeField()->setConfig('showdropdown', true);

		$fields->addFieldsToTab('Root.File', array(
			$bla = UploadField::create('File','FileUploadField')
				->setDescription($description)
				->setConfig('allowedMaxFileNumber', 1)
				->setConfig('canPreviewFolder', false),
			UploadField::create('AttachedFile','UploadField with canUpload=false')
				->setDescription($description)
				->setConfig('canUpload', false),
			UploadField::create('Image','UploadField for image')
				->setDescription($description),
			UploadField::create('HasManyFiles','UploadField for has_many')
				->setDescription($description),
			UploadField::create('ManyManyFiles','UploadField for many_many')
				->setDescription($description)
		));

		$data = $this->getDefaultData();
		foreach($fields->dataFields() as $field) {
			$name = $field->getName();
			if(isset($data[$name])) {
				$field->setValue($data[$name]);
			}
		}

		$blacklist = array('DMYDate');

		$tabs = array('Root.Text', 'Root.Numeric', 'Root.Option', 'Root.DateTime', 'Root.File');
		foreach($tabs as $tab) {
			$tabObj = $fields->fieldByName($tab);
			foreach($tabObj->FieldList() as $field) {
				$field
					->setDescription($description);
					// ->addExtraClass('cms-description-tooltip');

				if(in_array($field->getName(), $blacklist)) continue;

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
		$fields->addFieldToTab('Root.Text', $noLabelField, 'Text_disabled');

		$fields->addFieldToTab('Root.Text',
			FieldGroup::create(
				TextField::create('MyFieldGroup1'),
				TextField::create('MyFieldGroup2'),
				DropdownField::create('MyFieldGroup3', false, TestCategory::map())
			)
		);
		$fields->addFieldToTab('Root.Text',
			FieldGroup::create(
				'MyLabelledFieldGroup',
				array(
					TextField::create('MyLabelledFieldGroup1'),
					TextField::create('MyLabelledFieldGroup2'),
					DropdownField::create('MyLabelledFieldGroup3', null, TestCategory::map())
				)
			)->setTitle('My Labelled Field Group')
		);

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
