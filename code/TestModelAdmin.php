<?php

class TestModelAdmin extends ModelAdmin {
	static $url_segment = 'test';
	static $menu_title = 'Test ModelAdmin';

	public static $managed_models = array(
		"Company",
		"Employee",
	);

}

?>