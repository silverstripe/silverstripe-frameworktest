<?php

namespace SilverStripe\FrameworkTest\Elemental\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\FrameworkTest\Elemental\Model\ElementalBehatTestObject;

class ElementalBehatTestAdmin extends ModelAdmin
{
    private static $url_segment = 'elemental-behat-test-admin';
    private static $menu_title = 'Elemental Behat Test Admin';
    private static $menu_icon_class = 'font-icon-block-banner';

    private static $managed_models = [
        ElementalBehatTestObject::class,
    ];
}
