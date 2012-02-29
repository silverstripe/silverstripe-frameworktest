<?php

class Developer extends DataObject {
	static $db = array(
		"FirstName" => "Varchar",
		"Surname" => "Varchar",
		"Email" => "Varchar",
		"Username" => "Varchar",
	);
	static $belongs_many_many = array(
		"Projects" => "Project",
	);
}

?>