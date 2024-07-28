<?php

namespace SilverStripe\FrameworkTest\Elemental\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\FrameworkTest\Elemental\Model\MultiElementalBehatTestObject;

if (!class_exists(MultiElementalBehatTestObject::class)) {
    return;
}

class MutliElementalBehatTestAdmin extends ModelAdmin
{
    private static $url_segment = 'multi-elemental-behat-test-admin';

    private static $menu_title = 'Multi-elemental Behat Test Admin';

    private static $menu_icon_class = 'font-icon-block-banner';

    private static $managed_models = [
        MultiElementalBehatTestObject::class,
    ];

    private static $required_permission_codes = 'CMS_ACCESS_CMSMain';

}
