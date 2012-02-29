<?php

class Contact extends DataObject {
	static $db = array(
		"FirstName" => "Varchar",
		"Surname" => "Varchar",
		"Email" => "Varchar",
	);
	static $belongs_many_many = array(
		"Clients" => "Client",
	);
}

?>