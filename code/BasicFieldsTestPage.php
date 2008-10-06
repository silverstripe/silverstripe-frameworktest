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
		'DMYCalendarDate' => 'Date',
		'DMYDate' => 'Date',
		'DropdownTime' => 'Time',
		'PopupDateTime' => 'Datetime',
		'Time' => 'Time',
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
		'Image' => 'Image',
		'Image2' => 'Image',
		'Image3' => 'Image',
		'File' => 'File',
		'File2' => 'File',
		'File3' => 'File',
	);
	
	static $defaults = array(
		'Readonly' => 'Default value for \'readonly\'',
		"DateDisabled" => "2002-10-23",
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->addFieldsToTab('Root.Content.TextTests', array(
			new ReadonlyField('Readonly', 'ReadonlyField'),
			new TextareaField('Textarea', 'TextareaField - 8 rows', 8),
			new TextField('Text', 'TextField'),
			new HtmlEditorField('HTMLField', 'HtmlEditorField'),
		//	new HtmlOneLineField('HTMLOneLine', 'HTMLOneLineField'), // Doesn't work
			new EmailField('Email', 'EmailField'),
			new PasswordField('Password', 'PasswordField'),
			new ConfirmedPasswordField('ConfirmedPassword', 'ConfirmedPasswordField'),
			new UniqueTextField('UniqueText', 'UniqueText', 'BasicFieldsTestPage', 'This field must be unique.', 'UniqueTextField'),
			new UniqueRestrictedTextField('UniqueRestrictedText', 'UniqueRestrictedText', 'BasicFieldsTestPage', 'This field must be unique for each page',
								'[^A-Za-z0-9-]+', '-', 'This field can only be made up of letters, digits and hyphens.',
								'UniqueRestrictedTextField'),
			new AjaxUniqueTextField('AjaxUniqueText', 'AjaxUniqueTextField', 'AjaxjUniqueText', 'BasicFieldsTestPage'),
		//	new AutocompleteTextField('Autocomplete', 'AutocompleteTextField', Director::absoluteURL('BasicFieldsTestPage_Controller/AutoCompleteItems')), // Doesn't work
		));
		
		$fields->addFieldsToTab('Root.Content.NumericTests', array(
			new NumericField('Number', 'NumericField'),
			new CurrencyField('Price', 'CurrencyField'),
			new BankAccountField('BankNumber', 'BankAccountField'),
			new PhoneNumberField('PhoneNumber', 'PhoneNumberField'),
			new CreditCardField('CreditCard', 'CreditCardField'),
			new GSTNumberField('GSTNumber', 'GSTNumberField'),
		));
		
		$fields->addFieldsToTab('Root.Content.OptionTests', array(
			new CheckboxField('Checkbox', 'CheckboxField'),
			new DropdownField('DropdownID', 'DropdownField', TestCategory::map()),
			new GroupedDropdownField('GroupedDropdownID', 'GroupedDropdown', array('Test Categorys' => TestCategory::map())),
			new ListboxField('ListboxFieldID', 'ListboxField', TestCategory::map(), array(), 3),
			new OptionsetField('OptionSetID', 'OptionSetField', TestCategory::map()),
		));

		$fields->addFieldsToTab('Root.Content.DateTimeTests', array(
			new CalendarDateField('CalendarDate','CalendarDateField'),
			new CompositeDateField('CompositeDate','CompsiteDateField'),
			new DateField('Date','DateField'),
			new DateField_Disabled("DateDisabled","DateField_Disabled (should be 2002-10-23)"),
			new DMYCalendarDateField('DMYCalendarDate','DMYCalendarDateField'),
			new DMYDateField('DMYDate','DMYDateField'),
			new DropdownTimeField('DropdownTime','DropdownTimeField'),
			new PopupDateTimeField('PopupDateTime','PopupDateTimeField'),
			new TimeField('Time','TimeField')
		));

		$fields->addFieldsToTab('Root.Content.FileTests', array(
			new ImageField('Image','ImageField'),
			new SimpleImageField('Image2','SimpleImageField'),
			new ImageField('Image3','ImageField'),
			new FileIFrameField('File','FileIFrameField'),
			new FileField('File2','FileField'),
			new FileIFrameField('File3','FileIFrameField'),
		));
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
