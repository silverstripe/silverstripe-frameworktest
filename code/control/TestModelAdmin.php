<?php

class TestModelAdmin extends ModelAdmin {
	static $url_segment = 'test';
	static $menu_title = 'Test MdAdm';

	public static $managed_models = array(
		"Client",
		"Contact",
		"Project",
		"Developer",
	);

}

?>