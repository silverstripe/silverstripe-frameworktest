<?php
class TestMultiFormPage extends Page
{
}

class TestMultiFormPage_Controller extends Page_Controller
{
    
    public function Form()
    {
        $form = new TestMultiForm($this, 'Form', new FieldList(), new FieldList());

        return $form;
    }
    
    public function FormMessage()
    {
        if (Session::get('MultiFormMessage')) {
            $message = Session::get('MultiFormMessage');
            Session::clear('MultiFormMessage');
            
            return $message;
        }
        
        return false;
    }
}
