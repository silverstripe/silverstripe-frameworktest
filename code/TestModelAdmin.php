<?php

class TestModelAdmin extends ModelAdmin {
	static $url_segment = 'test';
	static $menu_title = 'Test ModelAdmin';

	static $managed_models = array(
		"Company",
		"Employee",
	);

}

?>