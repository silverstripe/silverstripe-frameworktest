<?php

namespace SilverStripe\FrameworkTest\Fields\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\FrameworkTest\Model\Company;

class GridFieldTestAdmin extends ModelAdmin
{
    private static string $url_segment = 'gridfield-test-admin';
    private static string $menu_title = 'GridField Test Admin';
    private static string $menu_icon_class = 'font-icon-block-banner';

    private static array $managed_models = [
        Company::class,
    ];
}
