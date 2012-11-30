<?php
class GridFieldTestPage extends TestPage {

	static $has_one = array(
		"HasOneCompany" => "Company",
	);

	static $has_many = array(
		"HasManyCompanies" => "Company",
	);

	static $many_many = array(
		"ManyManyCompanies" => "Company",
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$grids = array();

		$config = new GridFieldConfig_RecordEditor();
		$grid = new GridField('Companies', 'Companies', new DataList('Company'),$config);
		$fields->addFieldToTab('Root.NoRelation', $grid);
		$grids[] = $grid;

		$config = new GridFieldConfig_RelationEditor();
		$grid = new GridField('HasManyCompanies', 'HasManyCompanies', $this->HasManyCompanies(),$config);
		$fields->addFieldToTab('Root.HasMany', $grid);
		$grids[] = $grid;

		$config = new GridFieldConfig_RelationEditor();
		$grid = new GridField('ManyManyCompanies', 'ManyManyCompanies', $this->ManyManyCompanies(),$config);
		$fields->addFieldToTab('Root.ManyMany', $grid);
		$grids[] = $grid;

		foreach($grids as $grid) {
			$grid
				->setDescription('This is <strong>bold</strong> help text')
				->addExtraClass('cms-help');
				// ->addExtraClass('cms-help cms-help-tooltip');
		}

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
		$config = new GridFieldConfig_RecordEditor();
		
		$grid = new GridField('Companies', 'Companies', new DataList('Company'),$config);
		return new Form($this,'Form',new FieldList($grid),new FieldList());
	}
}
