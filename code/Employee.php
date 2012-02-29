<?php

/**
 * Description of Employees
 *
 */
class Employee extends DataObject {
	
	public static $db = array(
		'Name' => 'Varchar',
	);
	
	public static $has_one = array(
		'Company' => 'Company'
	);
	
	public function requireDefaultRecords() {
		parent::requireDefaultRecords();
		$employeeSet = DataObject::get('Employee');
		foreach ($employeeSet as $employee) {
			$employee->delete();
		}
		
		foreach($this->data() as $employeeName){
			$employee = new Employee();
			$employee->Name = $employeeName;
			$employee->write();
		}
		DB::alteration_message("Added default records to Employee table","created");
	}
	
	/**
	 * Contains test data
	 *
	 * @return array
	 */
	public function data() {
		return array(
			'Hayley', 'Octavius', 'Walker', 'Gary','Elton','Janna','Ursa','Lars','Moses','Lareina',
			'Elmo','Cara','Shea','Duncan','Velma','Acton','Galena','Heidi','Troy','Elliott','Cara',
			'Whitney','Summer','Olga','Tatum','Zeph','Jared','Hilda','Quinlan','Chaim','Xenos',
			'Cara','Tatiana','Tyrone','Juliet','Chester','Hannah','Imani','Quinn','Ariel','Abel',
			'Aretha','Courtney ','Shellie','Garrett','Camilla','Simon','Mohammad','Kirby','Rae',
			'Xena','Noel','Omar','Shannon','Iola','Maia','Serina','Taylor','Alice','Lucy','Austin',
			'Abel','Quinn','Yetta','Ulysses','Donovan','Castor','Emmanuel','Nero','Virginia',
			'Gregory','Neville','Abel','Len','Knox','Gavin','Pascale','Hyatt','Alden','Emerald',
			'Cherokee','Zeph','Adam','Uma','Serena','Isabelle','Kieran','Moses','Gay','Lavinia',
			'Elvis','Illana','Lee','Ariana','Hilel','Juliet','Gage','Larissa','Richard','Allen'
		);	
	}
}
