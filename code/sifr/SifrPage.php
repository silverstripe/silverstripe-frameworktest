<?php 
class SifrPage extends Page
{
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab("Root.Content.SifrSampleImage", new LiteralField("SifrSampleImage", '<p><img src="frameworktest/images/sifr_sample.png"/></p>'));
        
        return $fields;
    }
}

class SifrPage_Controller extends Page_Controller
{
    
    public function init()
    {
        parent::init();
        
        Sifr::add_font('blackout', 'themes/fonts/blackout.swf');
        Sifr::replace_element('blackout', 'h2', "'.sIFR-root { text-align: left; color: red;'");
        Sifr::replace_element('blackout', 'h3', "'.sIFR-root { text-align: left; color: red;'");
        Sifr::replace_element('blackout', 'h4', "'.sIFR-root { text-align: left; color: red;'");
        Sifr::activate_sifr();
    }
}
