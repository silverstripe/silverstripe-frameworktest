<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Control\Session;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\TextField;
class TestMultiForm extends MultiForm
{
    public static $start_step = 'TestMultiFormStepOne';
    
    public function finish(array $data, Form $form): HTTPResponse
    {
        parent::finish($data, $form);
        
        $savedSteps = $this->getSavedSteps();
        
        $savedData = array();
        foreach ($savedSteps as $step) {
            $savedData = array_merge($savedData, $step->loadData());
        }
        
        $fields = new FieldList();
        $fields->push(new LiteralField("Heading", "<h3>You have submitted the following information:</h3>"));
        
        foreach ($savedData as $key=>$value) {
            $fields->push(new LiteralField($key . '_copy', "<p><strong>$key</strong> $value</p>"));
        }
        
        Session::set("MultiFormMessage", "Your information has been submitted.");
        
        return $this->Controller()->redirect(Director::BaseURL() . $this->Controller()->URLSegment);
    }
}

class TestMultiFormStepOne extends MultiFormStep
{
    public static $next_steps = 'TestMultiFormStepTwo';
    
    public function getFields()
    {
        return new FieldList(
            new TextField('FirstName', 'First name'),
            new TextField('Surname', 'Surname')
        );
    }
}

class TestMultiFormStepTwo extends MultiFormStep
{
    public static $next_steps = 'TestMultiFormStepThree';
    
    public function getFields()
    {
        return new FieldList(
            new TextField('Email', 'Email'),
            new TextField('Address', 'Address')
        );
    }
}


class TestMultiFormStepThree extends MultiFormStep
{
    public static $is_final_step = true;
    
    public function getFields()
    {
        $form = $this->getForm();
        $savedSteps = $form->getSavedSteps();
    
        $savedData = array();
        foreach ($savedSteps as $step) {
            $savedData = array_merge($savedData, $step->loadData());
        }
        
        $fields = new FieldList();
        $fields->push(new LiteralField("Heading", "<h3>You have submitted the following information:</h3>"));
        
        foreach ($savedData as $key=>$value) {
            if (preg_match("/_copy$/", $key ?? '')) {
                continue;
            }
            
            $fields->push(new LiteralField($key . '_copy', "<p><strong>$key</strong> $value</p>"));
        }
        
        return $fields;
    }
}
