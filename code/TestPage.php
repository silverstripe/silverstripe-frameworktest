<?php

namespace SilverStripe\FrameworkTest\Model;

use Page;
use PageController;
use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\TextField;
use SilverStripe\Control\Email\Email;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

/**
 * Parent class of all test pages
 */
class TestPage extends Page
{
    private static $table_name = 'TestPage';

    /**
     * We can only create subclasses of TestPage
     */
    public function canCreate($member = null, $context = array())
    {
        // Don't allow creation other than through requireDefaultRecords
        return false;
    }

    public function requireDefaultRecords()
    {
        if (static::class === self::class) {
            return;
        }

        if (!DataObject::get_one(static::class)) {
            // Try to create common parent
            Member::actAs(Security::findAnAdministrator(), function () {
                $parent = SiteTree::get()
                    ->filter('URLSegment', 'feature-test-pages')
                    ->First();

                if (!$parent) {
                    $parent = new Page(array(
                        'Title' => 'Feature Test Pages',
                        'Content' => 'A collection of pages for testing various features in the SilverStripe CMS',
                        'ShowInMenus' => 0
                    ));
                    $parent->write();
                    $parent->doPublish();
                }

                // Create actual page
                $page = new static();
                $page->Title = str_replace(self::class, "", static::class);
                $page->ShowInMenus = 0;
                if ($parent) {
                    $page->ParentID = $parent->ID;
                }
                $page->write();
                $page->publish('Stage', 'Live');
            });
        }
    }
}

/**
 * Parent class of all test page controllers
 */
class TestPage_Controller extends PageController
{
    private static $allowed_actions = array(
        'Form',
        'save',
    );

    /**
     * This form is exactly like the CMS form.  It gives us an opportunity to test the fields outside of the CMS context
     */
    public function Form()
    {
        $fields = $this->getCMSFields();
        $actions = new FieldList(
            new FormAction("save", "Save"),
            $gohome = new FormAction("gohome", "Go home")
        );
        $gohome->setAttribute('src', 'frameworktest/images/test-button.png');
        $form = new Form($this, "Form", $fields, $actions);
        $form->loadDataFrom($this->dataRecord);
        return $form;
    }

    public function save($data, $form)
    {
        $form->saveInto($this->dataRecord);
        $this->dataRecord->write();
        $this->redirectBack();
    }

    public function gohome()
    {
        $this->redirect("./");
    }

    public function EmailForm()
    {
        return new Form($this, "EmailForm", new FieldList(
            new TextField("Email", "Email address")
        ), new FieldList(
            new FormAction("sendEmail", "Send test email to this address")
        ));
    }

    public function email()
    {
        return array(
            'Content' => '<p>Use this form to send a test email</p>',
            'Form' => $this->EmailForm()
        );
    }

    public function sendEmail($data, $form)
    {
        $email = new Email();
        $email->setTo($data['Email']);
        $email->setFrom($data['Email']);
        $email->setSubject('A subject with some umlauts: öäüß');
        $email->setBody('A body with some umlauts: öäüß');
        $email->send();

        echo "<p>email sent to " . $data['Email'] . "</p>";
    }
}
