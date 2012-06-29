<?php

class BigFamilyPage extends Page{
	public function requireDefaultRecords() {
		parent::requireDefaultRecords();
		
		//clear all old records
		$bigFmailyPages = DB::query("SELECT \"SiteTree_Live\".\"ID\" FROM \"SiteTree_Live\" WHERE \"SiteTree_Live\".\"ClassName\" = 'BigFamilyPage'")->column();
		if(count($bigFmailyPages)){
			$ids = "(".implode(",", $bigFmailyPages).")";
			//Delete all children from all stages
			DB::query("DELETE FROM \"SiteTree\" WHERE \"SiteTree\".\"ParentID\" IN $ids");
			DB::query("DELETE FROM \"SiteTree_versions\" WHERE \"SiteTree_versions\".\"ParentID\" IN $ids");
			DB::query("DELETE FROM \"SiteTree_Live\" WHERE \"SiteTree_Live\".\"ParentID\" IN $ids");
			
			//Delete themselves from all stages
			DB::query("DELETE FROM \"SiteTree\" WHERE \"SiteTree\".\"ID\" IN $ids");
			DB::query("DELETE FROM \"SiteTree_versions\" WHERE \"SiteTree_versions\".\"RecordID\" IN $ids");
			DB::query("DELETE FROM \"SiteTree_Live\" WHERE \"SiteTree_Live\".\"ID\" IN $ids");
		}
		
		//create new records
		$bigFamilyPages = DataObject::get('BigFamilyPage');
		foreach ($bigFamilyPages as $page) {
			foreach($page->AllChildren() as $child){
				$child->delete();
			}
			$page->delete();
		}
		
		$familyPage = new BigFamilyPage();
		$familyPage->Title = "Big Family";
		$familyPage->write();
		$familyPage->publish('Stage', 'Live');
		
		foreach(singleton('Employee')->data() as $name){
			$page = new Page();
			$page->Title = $name;
			$page->MenuTitle = $name;
			$page->ParentID = $familyPage->ID;
			$page->write();
			$page->publish('Stage', 'Live');
		}
		
		DB::alteration_message("Added default 'BigFamilyPage' and its children pages","created");
	}
}

class BigFamilyPage_Controller extends Page_Controller{
}