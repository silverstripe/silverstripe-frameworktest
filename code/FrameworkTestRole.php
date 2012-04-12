<?php

class FrameworkTestRole extends DataExtension {
	function extraStatics($class = null, $extension = null) {
		return array(
			'has_one' => array(
				'FavouritePage' => 'SiteTree',
			),
		);
	}
	
	function updateCMSFields(FieldList $fields) {
		$fields->push(new TreeDropdownField("FavouritePageID", "Favourite page", "SiteTree"));
	}
	
	function requireDefaultRecords() {
		$hasTestMembers = DataObject::get('Member')->find('Email', 'hayley@test.com');
		if(!$hasTestMembers) {

			foreach($this->data() as $name) {
				$member = new Member(array(
					'FirstName' => $name,
					'FirstName' => 'Smith',
					'Email' => "{$name}@test.com",
				));
				$member->write();
			}

			DB::alteration_message("Added default records to Member table","created");
		}
	}

	/**
	 * Contains test data
	 *
	 * @return array
	 */
	public function data() {
		return array(
			'Hayley', 'Octavius', 'Walker', 'Gary', 'Elton', 'Janna', 'Ursa', 'Lars', 'Moses', 'Lareina', 'Elmo', 'Shea', 'Duncan', 'Velma', 'Acton', 'Galena', 'Heidi', 'Troy', 'Elliott', 'Whitney', 'Summer', 'Olga', 'Tatum', 'Zeph', 'Jared', 'Hilda', 'Quinlan', 'Chaim', 'Xenos', 'Cara', 'Tatiana', 'Tyrone', 'Juliet', 'Chester', 'Hannah', 'Imani', 'Quinn', 'Ariel', 'Aretha', 'Courtney ', 'Shellie', 'Garrett', 'Camilla', 'Simon', 'Mohammad', 'Kirby', 'Rae', 'Xena', 'Noel', 'Omar', 'Shannon', 'Iola', 'Maia', 'Serina', 'Taylor', 'Alice', 'Lucy', 'Austin', 'Abel', 'Yetta', 'Ulysses', 'Donovan', 'Castor', 'Emmanuel', 'Nero', 'Virginia', 'Gregory', 'Neville', 'Len', 'Knox', 'Gavin', 'Pascale', 'Hyatt', 'Alden', 'Emerald', 'Cherokee', 'Adam', 'Uma', 'Serena', 'Isabelle', 'Kieran', 'Gay', 'Lavinia', 'Elvis', 'Illana', 'Lee', 'Ariana', 'Hilel', 'Gage', 'Larissa', 'Richard', 'Allen'
		);	
	}
}
