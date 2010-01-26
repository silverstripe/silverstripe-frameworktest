<?php

class Client extends DataObject {
	static $db = array(
		"Name" => "Varchar",
		"Notes" => "HTMLText",
	);
	static $many_many = array(
		"Contacts" => "Contact",
	);
	static $belongs_many_many = array(
		"Projects" => "Project",
	);
}

?>