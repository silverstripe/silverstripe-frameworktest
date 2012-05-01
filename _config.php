<?php

Object::add_extension('Member', 'FrameworkTestRole');
Object::add_extension('Member', 'FileUploadRole');
Object::add_extension('SiteTree', 'FrameworkTestSiteTreeExtension');

if(class_exists('SiteTreeCMSWorkflow')) {
	Object::add_extension('SiteConfig', 'CMSWorkflowSiteConfigDecorator');
	CMSWorkflowSiteConfigDecorator::apply_active_config();
}

Director::addRules(100, array(
	'dev/regress/$Action/$ID' => 'FrameworktestRegressSessionAdmin'
));

if(@$_GET['db']) {
	$enabletranslatable = @$_GET['enabletranslatable'];
} elseif(@$_SESSION['db']) {
	$enabletranslatable = @$_SESSION['enabletranslatable'];
} else {
	$enabletranslatable = null;
}
if($enabletranslatable) {
	Object::add_extension('SiteTree', 'Translatable');
	Object::add_extension('SiteConfig', 'Translatable');
}
?>