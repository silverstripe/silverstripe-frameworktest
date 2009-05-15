<?php

class TestModelAdmin extends ModelAdmin {
	public static $managed_models = array(
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