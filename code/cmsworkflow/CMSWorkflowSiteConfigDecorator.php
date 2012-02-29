<?php
/**
 * Extends cmsworkflow to provide an ability to switch bewteen Two-Step and Three-Step workflow mode in SiteConfig in the CMS
 * The configuration is stored in a text in {@see self::get_config_file_path()}. Database couldn't be used to store config
 * since self::apply_active_config() is invoked the in a _config.php, before database api is ready.
 * 
 * The config is in form of:
 * <code>
 * 		STEP = threestep
 * 		OTHERCONFIG = value
 * 		...
 * </code>
 *
 * The STEP config can be either twostep or threestep where twostep is the default 
 *
 */
class CMSWorkflowSiteConfigDecorator extends DataObjectDecorator {
	
	static $config_file_path = '';
	
	static $step_config =  "twostep" ;
	
	static $default_config = "STEP = twostep";
	
	/**
	 * @TODO: add javascript that instantly appends "(active)" to the links - "Set to Two-Step" and "Set to Three-Step"
	 */ 
	function updateCMSFields(&$fields) {
		$twoStepActive = "";
		$threeStepActive = "";
		$whichStep = self::get_step_config();
		
		if($whichStep == 'threestep') {
			$threeStepActive = "(active)";
		}
		else {
			$twoStepActive = "(active)";
		}
		
		$fields->addFieldToTab("Root.Main", new HeaderField("WorkflowHeader", "CMS Workflow Configuration"));
		
		$fields->addFieldToTab("Root.Main", new LiteralField("WorkflowTwoStepLink", '<p><a target="_blank" href="CMSWorkflowSiteConfigController/setStepConfig/twostep">Set to Two Step</a> <span>' . $twoStepActive . '</span></p>'));
		
		$fields->addFieldToTab("Root.Main", new LiteralField("WorkflowThreeStepLink", '<p><a target="_blank" href="CMSWorkflowSiteConfigController/setStepConfig/threestep">Set to Three Step</a> <span>' . $threeStepActive . '</span></p>'));
	}
	
	/**
	 * Apply two step (config) or three step workflow config.
	 * Two step config is already set in the module so SiteConfig::WorkflowStepConfig is twostep we don't need to do anything
	 */
	static function apply_active_config() {
		$whichStep = self::get_step_config();
		
		if($whichStep == 'threestep') {
			// remove two-step decorators
			Object::remove_extension('WorkflowRequest', 'WorkflowTwoStepRequest');
			Object::remove_extension('SiteTree', 'SiteTreeCMSTwoStepWorkflow');
			Object::remove_extension('SiteConfig', 'SiteConfigTwoStepWorkflow');
			
			// add three-step decorators
			Object::add_extension('WorkflowRequest', 'WorkflowThreeStepRequest');
			Object::add_extension('SiteTree', 'SiteTreeCMSThreeStepWorkflow');
			Object::add_extension('LeftAndMain', 'LeftAndMainCMSThreeStepWorkflow');
			Object::add_extension('SiteConfig', 'SiteConfigThreeStepWorkflow');
		}
		
	}
	
	/**
	 * Get STEP config variable from file self::get_config_file_path()
	 * @return	string | the value of the config variable
	 */ 
	static function get_step_config() {
		$config = self::get_config_content();
		$value = self::get_config($config, "STEP");
		
		return $value;
	}
	
	/**
	 * Set Get STEP config varial from file self::get_config_file_path()
	 */
	static function set_step_config($val) {
		$config = self::get_config_content();
		$newContent = self::set_config($config, "STEP", $val);
		self::write_config_file($newContent);
	}
	
	/**
	 * Config file path for frameworktest - two step and three step testing 
	 */ 
	static function get_config_file_path() {
		if (self::$config_file_path) {
			return self::$config_file_path;
		} else {
			return dirname(__FILE__) . "/CMSWorkflow_Config.cfg";
		}
	}
	
	/**
	 * Config file path for frameworktest - two step and three step testing 
	 * @return file handler
	 */
	static function get_config_file($mode = "r+") {
		$path = self::get_config_file_path();
		
		// create if not existing
		if(!file_exists($path)) {
			$file = fopen($path, "w");
			// default config
			fwrite($file, self::$default_config);
			fclose($file);
		}
		
		return fopen($path, $mode);
	} 
	
	/**
	 * Config file path for frameworktest - two step and three step testing 
	 * @return file handler
	 */
	static function write_config_file($content) {
		$file = self::get_config_file();
		
		// clear the file first
		ftruncate($file, 0);
		
		fwrite($file, $content);
		fclose($file);
	}
	
	/**
	 * Config file path for frameworktest - two step and three step testing 
	 * @return string
	 */
	static function get_config_content() {
		$file = self::get_config_file();
		
		$content = null;
		while(!@feof($file)) {
			$content .= @fread($file, 10);
		}
		
		fclose($file);
		
		return $content;
	}
	
	/**
	 * 
	 * @param content from the file return from self::get_config_file
	 * @param config variable
	 */ 
	static function get_config($content, $var) {
		$pattern = "/$var\s*=\s*([\w_]*)/";
		preg_match($pattern, $content, $matches);
		
		if(count($matches) < 2) return false;
		
		return $matches[1];
	}
	
	/**
	 * @param content from the file return from self::get_config_file
	 * @param config variable
	 * @param value of the config variable
	 * @return string | new content
	 */ 
	static function set_config($content, $var, $value) {
		$pattern = "/$var\s*=\s*([\w_]*)/";
		$replaced = preg_replace($pattern, "$var = $value", $content);
		
		// if there varial is not found in the config a new a new one
		if(preg_match($pattern, $content) == 0) {
			if (trim($replaced) == "") {
				$replaced = self::$default_config;
			}
			else {
				$newConfig = "$var = $value";
				$replaced = trim($replaced) . "\n" . $newConfig;
			}
		}
		return $replaced;
	}
	

}