<?php
class CMSWorkflowSiteConfigDecoratorTest extends SapphireTest {
	
	protected $workflowConfigPath = "";
	
	function setUp() {
		// Change CMSWorkflow config file path to test directory so it doesn't mess up with the real config file
		$this->workflowConfigPath = dirname(__FILE__) . "/CMSWorkflow_Config.cfg";
		CMSWorkflowSiteConfigDecorator::$config_file_path = $this->workflowConfigPath;
	}
	
	function testGetConfigFile() {
		$file = CMSWorkflowSiteConfigDecorator::get_config_file();
		$content = $this->readFile($this->workflowConfigPath);

		// the size and the content of the initial config file are the same CMSWorkflowSiteConfigDecorator::$default_config's 
		$workflowDefaultConfig = CMSWorkflowSiteConfigDecorator::$default_config;
		$this->assertEquals($workflowDefaultConfig, $content);
		
		fclose($file);
	}
	
	function testGetConfigContent() {
		$content = CMSWorkflowSiteConfigDecorator::get_config_content();
		$content2 = $this->readFile($this->workflowConfigPath);
		
		$this->assertEquals($content, $content2);
	}
	
	function testWriteConfigFile() {
		CMSWorkflowSiteConfigDecorator::write_config_file("New workflow config");
		$content = $this->readFile($this->workflowConfigPath);
		$this->assertEquals("New workflow config", $content);
		
		CMSWorkflowSiteConfigDecorator::write_config_file("New workflow config two");
		$content = $this->readFile($this->workflowConfigPath);
		$this->assertEquals("New workflow config two", $content);
		
		CMSWorkflowSiteConfigDecorator::write_config_file("Config three");
		$content = $this->readFile($this->workflowConfigPath);
		$this->assertEquals("Config three", $content);
	}
	
	function testGetConfig() {
		$content = "STEP = twostep\nTESTCONFIG = test";
		
		$value = CMSWorkflowSiteConfigDecorator::get_config($content, "STEP");
		$this->assertEquals("twostep", $value);
		
		$value = CMSWorkflowSiteConfigDecorator::get_config($content, "TESTCONFIG");
		$this->assertEquals("test", $value);
		
		$value = CMSWorkflowSiteConfigDecorator::get_config($content, "NOTEXISTING");
		$this->assertEquals("", $value);
	}
	
	function testWriteConfig() {
		$content = "STEP = twostep\nTESTCONFIG = test";
		
		$newContent = CMSWorkflowSiteConfigDecorator::set_config($content, "STEP", 'threestep');
		$this->assertEquals("STEP = threestep\nTESTCONFIG = test", $newContent);
		
		$newContent = CMSWorkflowSiteConfigDecorator::set_config($content, "TESTCONFIG", '');
		$this->assertEquals("STEP = twostep\nTESTCONFIG = ", $newContent);
		
		$newContent = CMSWorkflowSiteConfigDecorator::set_config($content, "NEWCONFIG", 'newstuff');
		$this->assertEquals("STEP = twostep\nTESTCONFIG = test\nNEWCONFIG = newstuff", $newContent);
	}
	
	function testGetStepConfig() {
		$value = CMSWorkflowSiteConfigDecorator::get_step_config();
		$this->assertEquals("twostep", $value);
	}
	
	function testSetStepConfig() {
		CMSWorkflowSiteConfigDecorator::set_step_config("threestep");
		$content = $this->readFile($this->workflowConfigPath);
		$this->assertEquals("STEP = threestep", $content);
		
		CMSWorkflowSiteConfigDecorator::set_step_config("");
		$content = $this->readFile($this->workflowConfigPath);
		$this->assertEquals("STEP = ", $content);
		
		CMSWorkflowSiteConfigDecorator::set_step_config("twostep");
		$content = $this->readFile($this->workflowConfigPath);
		$this->assertEquals("STEP = twostep", $content);
	}
		
	function tearDown() {
		// delete the config file before begin the test 
		$path = CMSWorkflowSiteConfigDecorator::get_config_file_path();
		if(file_exists($path)) {
			unlink(CMSWorkflowSiteConfigDecorator::get_config_file_path());
		}
		
		// Remove custom CMSWorkflow config file path
		CMSWorkflowSiteConfigDecorator::$config_file_path = '';
	}
	
	/**
	 * Read the whole content of a (text) file. 
	 * Having this method so that we can avoid relying on CMSWorkflowSiteConfigDecorator::get_config_content()
	 * @return string - content of the file
	 */
	private function readFile($path) {
		// create if not existing
		if(!file_exists($path)) {
			return array(null, null);
		}
		
		$file = fopen($path, 'r');
		
		$content = null;
		while(!feof($file)) {
			$content .= fread($file, 10);
		}
		
		fclose($file);
		
		return $content;
	}

	
}