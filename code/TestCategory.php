<?php

/**
 * A data type that is related many-many to RelationFieldsTestPage, for testing purposes
 */
class TestCategory extends DataObject
{
    private static $db = array(
        "Title" => "Varchar",
    );
    private static $belongs_many_many = array(
        "RelationPages" => "RelationFieldsTestPage",
    );
    
    /**
     * Returns a dropdown map of all objects of this class
     */
    public static function map()
    {
        $categories = DataObject::get('TestCategory');
        if ($categories) {
            return $categories->map('ID', 'Title')->toArray();
        } else {
            return array();
        }
    }

    public function requireDefaultRecords()
    {
        $class = $this->class;
        if (!DataObject::get_one($class)) {
            foreach (array("A", "B", "C", "D") as $item) {
                $page = new $class();
                $page->Title = "Test Category $item";
                $page->write();
            }
        }
    }
}
