<?php
class RecaptchaTestPage extends Page
{
}

class RecaptchaTestPage_Controller extends Page_Controller
{
    
    public function Form()
    {
        $fields = new FieldList(
            new TextField('MyText')
        );
        if (class_exists('RecaptchaField')) {
            $fields->push(new RecaptchaField('MyRecaptcha'));
        } else {
            $fields->push(new LiteralField('<p class="message error">RecaptchaField class not found</p>'));
        }
        
        $form = new Form(
            $this,
            'Form',
            $fields,
            new FieldList(
                new FormAction('submit', 'submit')
            ),
            new RequiredFields(array('MyText'))
        );
        
        return $form;
    }
    
    public function submit($data, $form)
    {
        $form->sessionMessage('Hooray!', 'good');
        
        return Director::redirectBack();
    }
}
