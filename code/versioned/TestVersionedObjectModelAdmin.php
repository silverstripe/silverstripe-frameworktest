<?php

namespace SilverStripe\FrameworkTest\Versioned\Admin;

use SilverStripe\Admin\ModelAdmin;

class TestVersionedObjectModelAdmin extends ModelAdmin
{
    private static $url_segment = 'versioned-test';
    private static $menu_title = 'Test Versioned Object';

    private static $managed_models = [
        "SilverStripe\\FrameworkTest\\Versioned\\Model\\VersionedParentObject",
        "SilverStripe\\FrameworkTest\\Versioned\\Model\\NonVersionedParentObject",
    ];
}
