<?php

class Page2MultiFormTestPage extends Page
{
}

class Page2MultiFormTestPage_Controller extends PageController
{

    public function Page2MultiForm()
    {
        return new Page2MultiForm($this, 'Page2MultiForm');
    }

    public function finished()
    {
        return array(
            'Title' => 'Thank you for your submission',
            'Content' => '<p>You have successfully submitted the form. Thanks!</p>'
        );
    }
}
