<?php

class TestModelAdmin extends ModelAdmin
{
    private static $url_segment = 'test';
    private static $menu_title = 'Test ModelAdmin';

    private static $managed_models = array(
        "SilverStripe\\FrameworkTest\\Model\\Company",
        "SilverStripe\\FrameworkTest\\Model\\Employee",
    );
}
