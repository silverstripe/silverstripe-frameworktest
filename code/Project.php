<?php

class Project extends DataObject {
	static $db = array(
		"Name" => "Varchar",
	);
	static $many_many = array(
		"Clients" => "Client",
		"Developers" => "Developer",
	);
}

?>