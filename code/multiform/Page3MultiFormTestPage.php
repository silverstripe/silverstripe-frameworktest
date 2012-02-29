<?php

class Page3MultiFormTestPage extends Page {

	static $db = array(
	);

	static $has_one = array(
   );

}

class Page3MultiFormTestPage_Controller extends Page_Controller {
	
	function Page3MultiForm() {
	   return new Page3MultiForm($this, 'Page3MultiForm');
	}

	function finished() {
		return array(
			'Title' => 'Thank you for your submission',
			'Content' => '<p>You have successfully submitted the form. Thanks!</p>'
		);
	}

}

?>