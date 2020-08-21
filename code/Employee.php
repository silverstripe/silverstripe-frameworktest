<?php

namespace SilverStripe\FrameworkTest\Model;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\Connect\MySQLSchemaManager;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\Filters\ExactMatchFilter;
use SilverStripe\ORM\Filters\FulltextFilter;


/**
 * @property string $Name
 * @property string $Biography
 * @property string $DateOfBirth
 * @property string $Category
 * @property int $CompanyID
 * @property int $ProfileImageID
 * @method Company Company()
 * @method Image ProfileImage()
 */
class Employee extends DataObject
{

    private static $db = array(
        'Name' => 'Varchar',
        'Biography' => 'HTMLText',
        'DateOfBirth' => 'Date',
        'Category' => 'Enum("marketing,management,rnd,hr")'
    );

    private static $has_one = [
        'Company' => Company::class,
        'ProfileImage' => Image::class
    ];

    private static $belongs_many_many  = [
        'PastCompanies' => Company::class
    ];

    private static $indexes = [
        'SearchFields' => [
            'type' => 'fulltext',
            'columns' => ['Name', 'Biography'],
        ]
    ];

    private static $create_table_options = [
        MySQLSchemaManager::ID => 'ENGINE=MyISAM'
    ];

    private static $summary_fields = [
        'ID',
        'Name',
        'Biography',
        'CompanyID',
        'Company.Name' => 'Company',
        'ColleagueNames' => 'Colleague Names',
        'DateOfBirth',
        'Category'
    ];

    private static $searchable_fields = [
        'Name',
        'CompanyID',
        'Company.Name' => array(
            'title' => 'Company Name starting with',
            'field' => TextField::class,
            'filter' => 'StartsWithFilter'
        ),
        'Company.Employees.Name' => array('title' => 'Colleague'),
        'DateOfBirth',
        'Category'
    ];

    private static $table_name = 'Employee';

    public function getCMSFields()
    {
        // Use basic scaffolder (no tabs)
        $fields = $this->scaffoldFormFields();
        $fields->push(new NumericField('ManyMany[YearStart]', 'Year started (3.1, many-many only)'));
        $fields->push(new TextField('ManyMany[Role]', 'Role (3.1, many-many only)'));
        return $fields;
    }

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();
        $employeeSet = DataObject::get(Employee::class);
        foreach ($employeeSet as $employee) {
            $employee->delete();
        }

        // By explicitly seeding our random generator, we'll always get the same sequence
        srand(5);

        $companyIDs = Company::get()->column();
        $companyCount = sizeof($companyIDs);

        $words = $this->words();
        $wordCount = sizeof($words);
        $categories = ['marketing', 'management', 'rnd', 'hr'];

        foreach ($this->data() as $employeeName) {
            $employee = Employee::create([
                'Name' => $employeeName,
                'CompanyID' => $companyIDs[rand(0, $companyCount-1)],
                'Biography' => implode(' ', [
                    $words[rand(0, $wordCount-1)],
                    $words[rand(0, $wordCount-1)],
                    $words[rand(0, $wordCount-1)],
                    $words[rand(0, $wordCount-1)],
                    ]),
                'DateOfBirth' => date("Y-m-d", rand(0, 500) * 24 * 60 * 60),
                'Category' => $categories[rand(0, 3)]
            ]);
            $employee->write();
        }
        DB::alteration_message("Added default records to Employee table", "created");

        // Let's rescrambled our random generator
        srand();
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

    /**
     * Random words used to build the BIO
     *
     * @return array
     */
    public function words()
    {
        return [
            "aquarist", "macedonian", "kalian", "knew", "cloisterless", "separation", "husker",
            "subhall", "relatable", "gyrofrequency", "mandating", "presentability", "catt", "folioing",
            "theodore", "yavar", "mutular", "umbrage", "reinstated", "sert", "nonemulous", "nutwood",
            "perikeiromene", "moi", "wordless", "downstage", "rsj", "nonanesthetized", "dunker",
            "preloan", "lev", "marlow", "unpaneled", "overliberally", "monasticism", "philoctetes",
            "amba", "fluffier", "volley", "unwasteful", "helpless", "gallico", "superexpectation",
            "quartermaster", "extenuative", "marriage", "tiberius", "horn", "yankeedom", "chabazite",
        ];
    }

    public function getDefaultSearchContext()
    {
        $context =  parent::getDefaultSearchContext();

        $context->addField(TextField::create('SearchFields', 'Full Text search'));
        $context->addFilter(FulltextFilter::create('SearchFields'));

        return $context;
    }

    public function getColleagueNames()
    {
        return implode(' ', $this->Company()->Employees()->column('Name'));
    }

    public function scaffoldSearchFields($_params = null)
    {
        $fields = parent::scaffoldSearchFields($_params); // TODO: Change the autogenerated stub

        $fields->replaceField(
            'CompanyID',
            DropdownField::create(
                'CompanyID',
                'Company',
                Company::get()->map()->toArray()
            )->setEmptyString(' ')
        );

        return $fields;
    }
}
