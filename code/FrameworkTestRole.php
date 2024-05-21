<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Member;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;



class FrameworkTestRole extends DataExtension
{

    private static $has_one = array(
        'FavouritePage' => 'SilverStripe\\CMS\\Model\\SiteTree',
    );

    protected function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab(
            'Root.Main',
            new TreeDropdownField("FavouritePageID", "Favourite page", "SilverStripe\\CMS\\Model\\SiteTree")
        );
    }

    public function requireDefaultRecords()
    {
        $hasTestMembers = Member::get()->find('Email', 'hayley@test.com');
        if (!$hasTestMembers) {
            foreach ($this->data() as $name) {
                $member = new Member(array(
                    'FirstName' => $name,
                    'FirstName' => 'Smith',
                    'Email' => "{$name}@test.com",
                ));
                $member->write();
            }

            DB::alteration_message("Added default records to Member table", "created");
        }
    }

    /**
     * Contains test data
     *
     * @return array
     */
    public function data()
    {
        return array(
            'Hayley', 'Octavius', 'Walker', 'Gary', 'Elton', 'Janna', 'Ursa', 'Lars', 'Moses', 'Lareina', 'Elmo', 'Shea', 'Duncan', 'Velma', 'Acton', 'Galena', 'Heidi', 'Troy', 'Elliott', 'Whitney', 'Summer', 'Olga', 'Tatum', 'Zeph', 'Jared', 'Hilda', 'Quinlan', 'Chaim', 'Xenos', 'Cara', 'Tatiana', 'Tyrone', 'Juliet', 'Chester', 'Hannah', 'Imani', 'Quinn', 'Ariel', 'Aretha', 'Courtney ', 'Shellie', 'Garrett', 'Camilla', 'Simon', 'Mohammad', 'Kirby', 'Rae', 'Xena', 'Noel', 'Omar', 'Shannon', 'Iola', 'Maia', 'Serina', 'Taylor', 'Alice', 'Lucy', 'Austin', 'Abel', 'Yetta', 'Ulysses', 'Donovan', 'Castor', 'Emmanuel', 'Nero', 'Virginia', 'Gregory', 'Neville', 'Len', 'Knox', 'Gavin', 'Pascale', 'Hyatt', 'Alden', 'Emerald', 'Cherokee', 'Adam', 'Uma', 'Serena', 'Isabelle', 'Kieran', 'Gay', 'Lavinia', 'Elvis', 'Illana', 'Lee', 'Ariana', 'Hilel', 'Gage', 'Larissa', 'Richard', 'Allen'
        );
    }
}
