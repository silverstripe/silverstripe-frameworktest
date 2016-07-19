<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

class Page2MultiForm extends MultiForm
{

    public static $start_step = 'Page2PersonalDetailsFormStep';

    public function finish($data, $form)
    {
        parent::finish($data, $form);
        $steps = DataObject::get('MultiFormStep', "SessionID = {$this->session->ID}");
        if ($steps) {
            foreach ($steps as $step) {
                if ($step->class == 'Page2PersonalDetailsFormStep') {
                    $member = new Member();
                    $data = $step->loadData();
                    if ($data) {
                        $member->update($data);
                        $member->write();
                    }
                }

                if ($step->class == 'Page2OrganisationDetailsFormStep') {
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
        $controller->redirect($controller->Link() . 'finished');
    }
}

class Page2PersonalDetailsFormStep extends MultiFormStep
{

    public static $next_steps = 'Page2OrganisationDetailsFormStep';

    public function getFields()
    {
        return new FieldList(
            new TextField('FirstName', 'First name'),
            new TextField('Surname', 'Surname')
        );
    }
}

class Page2OrganisationDetailsFormStep extends MultiFormStep
{

    public static $is_final_step = true;

    public function getFields()
    {
        return new FieldList(
            new TextField('OrganisationName', 'Organisation Name')
        );
    }
}
