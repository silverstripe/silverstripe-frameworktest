<?php

namespace SilverStripe\FrameworkTest\Model;


use NumericField;
use TextField;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;



/**
 * Description of Employees
 *
 */
class Employee extends DataObject
{

    private static $db = array(
        'Name' => 'Varchar',
        'Biography' => 'HTMLText'
    );

    private static $has_one = array(
        'Company' => 'SilverStripe\\FrameworkTest\\Model\\Company',
        'ProfileImage' => 'Image'
    );

    private static $belongs_many_many  = array(
        'PastCompanies' => 'SilverStripe\\FrameworkTest\\Model\\Company'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if (method_exists('SilverStripe\\ORM\\ManyManyList', 'getExtraFields')) {
            $fields->addFieldToTab('Root.Main',
                new NumericField('ManyMany[YearStart]', 'Year started (3.1, many-many only)')
            );
            $fields->addFieldToTab('Root.Main',
                new TextField('ManyMany[Role]', 'Role (3.1, many-many only)')
            );
        }

        // 3.1 only
        if (method_exists('UploadField', 'setAllowedFileCategories')) {
            $fields->dataFieldByName('ProfileImageID')->setAllowedFileCategories('image');
        }


        return $fields;
    }

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();
        $employeeSet = DataObject::get('SilverStripe\\FrameworkTest\\Model\\Employee');
        foreach ($employeeSet as $employee) {
            $employee->delete();
        }

        foreach ($this->data() as $employeeName) {
            $employee = new Employee();
            $employee->Name = $employeeName;
            $employee->write();
        }
        DB::alteration_message("Added default records to Employee table", "created");
    }

    public function validate()
    {
        $result = parent::validate();
        if (!$this->Name) {
            $result->error('"Name" can\'t be blank');
        }
        return $result;
    }

    /**
     * Contains test data
     *
     * @return array
     */
    public function data()
    {
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
