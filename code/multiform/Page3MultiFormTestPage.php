<?php

class Page3MultiFormTestPage extends Page
{
}

class Page3MultiFormTestPage_Controller extends PageController
{

    public function Page3MultiForm()
    {
        return new Page3MultiForm($this, 'Page3MultiForm');
    }

    public function finished()
    {
        return array(
            'Title' => 'Thank you for your submission',
            'Content' => '<p>You have successfully submitted the form. Thanks!</p>'
        );
    }
}
