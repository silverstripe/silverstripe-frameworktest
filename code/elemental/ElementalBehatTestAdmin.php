<?php

namespace SilverStripe\FrameworkTest\Elemental\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\FrameworkTest\Elemental\Model\ElementalBehatTestObject;

class ElementalBehatTestAdmin extends ModelAdmin
{
    private static string $url_segment = 'elemental-behat-test-admin';
    private static string $menu_title = 'Elemental Behat Test Admin';
    private static string $menu_icon_class = 'font-icon-block-banner';

    private static array $managed_models = [
        ElementalBehatTestObject::class,
    ];
}
