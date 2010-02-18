<?php 
class SifrPage extends Page {
	
}

class SifrPage_Controller extends Page_Controller {
	
	function init() {
		parent::init();
		
		Sifr::add_font('chunkfive', 'themes/fonts/chunkfive.swf');
		Sifr::replace_element('chunkfive', 'h2', "'.sIFR-root { text-align: left; color: red;'");
		Sifr::replace_element('chunkfive', 'h3', "'.sIFR-root { text-align: left; color: red;'");
		Sifr::replace_element('chunkfive', 'h4', "'.sIFR-root { text-align: left; color: red;'");
		Sifr::activate_sifr();
	}
}