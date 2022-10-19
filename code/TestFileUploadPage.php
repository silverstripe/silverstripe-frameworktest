<?php

use SilverStripe\FrameworkTest\Model\TestPage;
use SilverStripe\FrameworkTest\Model\TestPage_Controller;
use SilverStripe\Security\Member;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FileField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\Form;


class TestFileUploadPage extends TestPage
{
    private static $table_name = 'TestFileUploadPage';
}

class TestFileUploadPage_Controller extends TestPage_Controller
{
    private static $allowed_actions = array(
        'Form'
    );

    public function Form()
    {
        $fields = new FieldList(
            new EmailField('Email', 'EmailField'),
            new FileField('AFile', 'FileField'),
            $aImage = new UploadField('AImage', 'SimpleImageField')
        );

        $aImage->allowedExtensions = array('jpg', 'gif', 'png');

        $actions = new FieldList(
            new FormAction('addMember', "Add a member with two Files uploaded")
        );
        return new Form($this, "Form", $fields, $actions);
    }

    public function addMember(array $data, Form $form): HTTPResponse
    {
        $member = new Member();
        $form->saveInto($member);
        $member->write();
        return $this->redirectBack();
    }
}
