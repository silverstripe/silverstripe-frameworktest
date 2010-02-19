<?php
class CMSWorkflowSiteConfigController extends Controller {
	
	function init() {
		parent::init();
		
		if(!Director::is_cli() && !Permission::check("ADMIN")) return Security::permissionFailure();
	}
	
	function setStepConfig() {
		$whichStep = Director::URLParam("ID");
		$validSteps = array('twostep', 'threestep');
		
		if(!in_array($whichStep, $validSteps)) {
			return false;
		}
		
		CMSWorkflowSiteConfigDecorator::set_step_config($whichStep);
		echo "<p>CMS Workflow has been set to <strong>$whichStep</strong></p>";
		
		// rebuild the database schema
		Director::redirect("dev/build?flush=1");
		
		return true;
	}
	
	
}