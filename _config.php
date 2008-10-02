<?php

// Set up TestModelAdmin
Director::addRules(100, array(
	'admin/test' => 'TestModelAdmin',
));
LeftAndMain::add_menu_item('test', 'Test ModelAdmin', 'admin/test', 'TestModelAdmin');
