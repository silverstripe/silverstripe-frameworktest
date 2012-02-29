<?php
class GridFieldTestPage extends Page {
	
	public function requireDefaultRecords() {
		parent::requireDefaultRecords();
		$page = DataObject::get_one('GridFieldTestPage');
		
		if(!$page) {
			$page = new GridFieldTestPage();
		}
		
		$page->URLSegment = 'gridfieldtest';
		$page->Title = 'GridField Test';
		$page->ParentID = 0;
		$page->write();
		$page->doPublish();
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$config = new GridFieldConfig();
		$config->addComponent(new GridFieldDefaultColumns());
		$config->addComponent(new GridFieldSortableHeader());
		$config->addComponent(new GridFieldPaginator);
		$config->addComponent(new GridFieldFilter());
		$config->addComponent(new GridFieldAction_Delete());
		$config->addComponent(new GridFieldAction_Edit());
		$config->addComponent($forms = new GridFieldPopupForms());
		
		$grid = new GridField('Companies', 'Companies', new DataList('Company'),$config);

		$fields->addFieldToTab('Root.GridField', $grid);

		return $fields;
	}
}

class GridFieldTestPage_Controller extends Page_Controller {
	
	/**
	 *
	 * @var string
	 */
	public $Title = "GridFieldTestPage";
	
	public function init(){
		parent::init();
		Requirements::css('frameworktest/css/gridfieldtest.css','screen');
	}
	
	/**
	 *
	 * @return Form 
	 */
	public function Form(){
		$config = new GridFieldConfig();
		$config->addComponent(new GridFieldDefaultColumns());
		$config->addComponent(new GridFieldSortableHeader());
		$config->addComponent(new GridFieldPaginator);
		$config->addComponent(new GridFieldFilter());
		$config->addComponent(new GridFieldAction_Delete());
		$config->addComponent(new GridFieldAction_Edit());
		$config->addComponent(new GridFieldPopupForms());
		
		$grid = new GridField('Companies', 'Companies', new DataList('Company'),$config);
		return new Form($this,'Form',new FieldList($grid),new FieldList());
	}
}