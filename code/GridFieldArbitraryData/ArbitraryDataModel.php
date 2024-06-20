<?php

namespace SilverStripe\FrameworkTest\GridFieldArbitraryData;

use LogicException;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObjectInterface;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\Queries\SQLDelete;
use SilverStripe\ORM\Search\BasicSearchContext;
use SilverStripe\View\ArrayData;

/**
 * A class of arbitrary data for testing GridField components.
 *
 * It stores its data in the database, but it doesn't use DataObject abstractions
 * to do so. The database in this scenario could just as easily be an API or other
 * way to fetch and send data.
 */
class ArbitraryDataModel extends ArrayData implements DataObjectInterface
{
    /**
     * In order to validate that writing/deleting works for arbitrary data, we'll be storing these
     * records in the database - just not using the DataObject abstraction.
     *
     * For our purposes, the database is acting as an abitrary data storage layer. It could just as
     * easily be sending/recieving data through an API, for example.
     *
     * Note that the database will not be used for filtering/sorting/etc - it is only used to store
     * the data on save, delete the data on delete, and fetch the data when loading the admin.
     */
    public const TABLE_NAME = 'frameworktest_ArbitraryDataModel';

    /**
     * We need to ensure there is an ID field for new records
     */
    public function __construct($value = [])
    {
        if (!isset($value['ID'])) {
            $value['ID'] = 0;
        }
        parent::__construct($value);
    }

    /**
     * Stores the current data into the database - but could just as easily send it through an API
     * endpoint for storing somewhere else, or save to a file, etc.
     */
    public function write()
    {
        $isNew = !$this->ID;
        $now = DBDatetime::now()->Rfc2822();
        $record = $this->array;
        $record['LastEdited'] = $now;
        if ($isNew) {
            $record['Created'] = $now;
        }

        // Remove anything that isn't storable in the DB, such as Security ID
        $dbColumns = DB::field_list(ArbitraryDataModel::TABLE_NAME);
        foreach ($record as $fieldName => $value) {
            if (!array_key_exists($fieldName, $dbColumns)) {
                unset($record[$fieldName]);
            }
        }

        // This is basically a fancy SQLInsert or SQLUpdate - I just copied DataObject so I didn't have to think.
        $manipulation = [
            'command' => $isNew ? 'insert' : 'update',
            'fields' => $record,
        ];
        if (!$isNew) {
            $manipulation['id'] = $this->ID;
        }
        DB::manipulate([ArbitraryDataModel::TABLE_NAME => $manipulation]);

        if ($isNew) {
            // Must save the ID in this object so GridField knows what URL to redirect to.
            $this->ID = DB::get_generated_id(ArbitraryDataModel::TABLE_NAME);
        }
    }

    public function delete()
    {
        if (!$this->ID) {
            throw new LogicException('DataObject::delete() called on a record without an ID');
        }
        SQLDelete::create()->setFrom(ArbitraryDataModel::TABLE_NAME)->setWhere(['ID' => $this->ID])->execute();
        $this->ID = 0;
    }

    /**
     * Sets the value from the form
     */
    public function setCastedField($fieldName, $val)
    {
        $this->$fieldName = $val;
    }

    /**
     * Gives a localisable plural name for the class.
     *
     * Used in add button, breadcrumbs, and toasts
     */
    public function i18n_singular_name()
    {
        return _t(__CLASS__ . '.SINGULAR_NAME', 'Arbitrary Datum');
    }

    /**
     * Gives a localisable plural name for the class.
     *
     * Used in filter header as the placeholder text
     */
    public function i18n_plural_name()
    {
        return _t(__CLASS__ . '.PLURAL_NAME', 'Arbitrary Data');
    }

    /**
     * Used to auto-detect gridfield columns
     */
    public function summaryFields()
    {
        $fieldNames = $this->getFieldNames();
        $summaryFields = array_combine($fieldNames, $fieldNames);
        unset($summaryFields['ID']);
        return $summaryFields;
    }

    public function getDefaultSearchContext()
    {
        return BasicSearchContext::create(static::class);
    }

    public function scaffoldSearchFields()
    {
        $fieldNames = $this->getFieldNames();
        $fields = [HiddenField::create(BasicSearchContext::config()->get('general_search_field_name'))];
        foreach ($fieldNames as $fieldName) {
            if ($fieldName === 'ID' || $fieldName === 'Created' || $fieldName === 'LastEdited') {
                continue;
            }
            $fields[] = TextField::create($fieldName);
        }
        return FieldList::create($fields);
    }

    public function getCMSFields(): FieldList
    {
        $fieldNames = $this->getFieldNames();
        $fields = [];
        foreach ($fieldNames as $fieldName) {
            switch ($fieldName) {
                case 'ID':
                    $fields[] = HiddenField::create($fieldName);
                    break;
                case 'Created':
                case 'LastEdited':
                    $fields[] = DatetimeField::create($fieldName)->performReadonlyTransformation();
                    break;
                default:
                    $fields[] = TextField::create($fieldName);
            }
        }
        return FieldList::create($fields);
    }

    // Note that a FieldsValidator is used by default, but we can add additional validation if we want
    // by implementing this method:
    // public function getCMSCompositeValidator()
    // {
    //     return CompositeValidator::create([
    //         FieldsValidator::create(),
    //         RequiredFields::create(['Title']),
    //     ]);
    // }

    public function canCreate()
    {
        return true;
    }

    public function canEdit()
    {
        return true;
    }

    public function canDelete()
    {
        return true;
    }

    private function getFieldNames()
    {
        $fieldNames = array_keys(ArbitraryDataAdmin::getInitialRecords()[0]);
        $fieldNames[] = 'Created';
        $fieldNames[] = 'LastEdited';
        return $fieldNames;
    }
}
