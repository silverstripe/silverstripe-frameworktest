<?php

class TestModelAdmin extends ModelAdmin {
	protected static $managed_models = array(
		"Client",
		"Contact",
		"Project",
		"Developer",
	);
	
	function Link() {
		return 'admin/test';
	}
}

?>