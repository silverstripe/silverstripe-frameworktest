<?php
class FrameworkTestSiteTreeExtension extends DataExtension
{
    
    private static $has_one = array('RelationFieldsTestPage' => 'RelationFieldsTestPage');
    private static $belongs_many_many = array('RelationFieldsTestPages' => 'RelationFieldsTestPage');
}
