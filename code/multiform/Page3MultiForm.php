<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

class Page3MultiForm extends MultiForm
{
    public static $start_step = 'Page3StartFormStep';

    public function finish(array $data, Form $form): HTTPResponse
    {
        parent::finish($data, $form);
        $steps = DataObject::get('MultiFormStep', "SessionID = {$this->session->ID}");
        if ($steps) {
            foreach ($steps as $step) {
                if ($step->ClassName == 'Page3PersonalDetailsFormStep') {
                    $member = new Member();
                    $data = $step->loadData();
                    if ($data) {
                        $member->update($data);
                        $member->write();
                    }
                }

                if ($step->ClassName == 'Page3OrganisationDetailsFormStep') {
                    $organisation = new Organisation();
                    $data = $step->loadData();
                    if ($data) {
                        $organisation->update($data);
                        if ($member && $member->ID) {
                            $organisation->MemberID = $member->ID;
                        }
                        $organisation->write();
                    }
                }

                // Debug::show($step->loadData()); // Shows the step data (unserialized by loadData)
            }
        }
        $controller = $this->getController();
        return $controller->redirect($controller->Link() . 'finished');
    }
}

class Page3StartFormStep extends MultiFormStep
{

    public static $next_steps = 'Page3PersonalDetailsFormStep';

    public function getFields()
    {
        return new FieldList(
            new LiteralField('Details', '<b>This is important</b><br />
			<p>You will receiving email once you participate in this survey. <br />
			Under the new Unsolicited Electronic Messages Act 2007, we must have your consent to send emails relating to this form. <br />
			If you do not wish to receive these emails please use the unsubscribe checkbox at bottom of this form. <br />
			If you still wish to receive these emails, you do not have to do anything.</p><br />
			<p>For more information visit <a href=\"http://silverstripe.com\">http://www.silverstripe.com/</a></p>'),
            new CheckboxField('Unsubscribe', 'Tick that you confirm the above details.')
        );
    }
}

class Page3PersonalDetailsFormStep extends MultiFormStep
{

    public static $next_steps = 'Page3OrganisationDetailsFormStep';

    public function getFields()
    {
        return new FieldList(
             new TextField('FirstName', 'First name'),
             new TextField('Surname', 'Surname')
          );
    }
}

class Page3OrganisationDetailsFormStep extends MultiFormStep
{

    public static $is_final_step = true;

    public function getFields()
    {
        return new FieldList(
            new TextField('OrganisationName', 'Organisation Name')
        );
    }
}
