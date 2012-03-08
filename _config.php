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

Session::start();
if(@$_GET['db']) {
	$db = $_GET['db'];
} elseif(@$_SESSION['db']) {
	$db = $_SESSION['db'];
} else {
	$db = null;
}
if($db) {
	global $databaseConfig;
	if($db == 'mysql') {
		$databaseConfig['type'] = 'MySQLDatabase';
		$databaseConfig['server'] = SS_MYSQL_DATABASE_SERVER;
		$databaseConfig['username'] = SS_MYSQL_DATABASE_USERNAME;
		$databaseConfig['password'] = SS_MYSQL_DATABASE_PASSWORD;
	} else if($db == 'postgresql') {
		$databaseConfig['type'] = 'PostgreSQLDatabase';
		$databaseConfig['server'] = SS_PGSQL_DATABASE_SERVER;
		$databaseConfig['username'] = SS_PGSQL_DATABASE_USERNAME;
		$databaseConfig['password'] = SS_PGSQL_DATABASE_PASSWORD;
	} else if($db == 'mssql') {
		$databaseConfig['type'] = 'MSSQLDatabase';
		$databaseConfig['server'] = SS_MSSQL_DATABASE_SERVER;
		$databaseConfig['username'] = SS_MSSQL_DATABASE_USERNAME;
		$databaseConfig['password'] = SS_MSSQL_DATABASE_PASSWORD;
	} else if($db == 'sqlite3') {
		$databaseConfig['type'] = 'SQLite3Database';
	} else {
		// stick with default settings set through ConfigureFromEnv
	}
}

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