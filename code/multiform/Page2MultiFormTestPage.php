<?php

class Page2MultiFormTestPage extends Page {

}

class Page2MultiFormTestPage_Controller extends Page_Controller {
	
	function Page2MultiForm() {
	   return new Page2MultiForm($this, 'Page2MultiForm');
	}

	function finished() {
		return array(
			'Title' => 'Thank you for your submission',
			'Content' => '<p>You have successfully submitted the form. Thanks!</p>'
		);
	}

}

?>
