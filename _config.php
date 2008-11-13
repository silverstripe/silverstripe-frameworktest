<?php

// Set up TestModelAdmin
/*
Director::addRules(100, array(
	'admin/test' => 'TestModelAdmin',
));
CMSMenu::add_menu_item('test', 'Test ModelAdmin', 'admin/test', 'TestModelAdmin');
*/

Object::add_extension('Member', 'FrameworkTestRole');