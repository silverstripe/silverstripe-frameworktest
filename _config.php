<?php

use SilverStripe\Security\Member;

Member::add_extension('FrameworkTestRole');
Member::add_extension('FileUploadRole');
SiteTree::add_extension('FrameworkTestSiteTreeExtension');
File::add_extension('FrameworkTestFileExtension');

if(class_exists('SiteTreeCMSWorkflow')) {
	SiteConfig::add_extension('CMSWorkflowSiteConfigDecorator');
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
	SiteTree::add_extension('Translatable');
	SiteConfig::add_extension('Translatable');
}
