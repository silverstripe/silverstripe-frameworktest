<?php

namespace SilverStripe\FrameworkTest\Fields\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\FrameworkTest\Model\Company;

class GridFieldTestNavigation extends ModelAdmin
{
    private static string $url_segment = 'gridfield-test-navigation';
    private static string $menu_title = 'GridField Test Navigation';
    private static string $menu_icon_class = 'font-icon-block-banner';

    private static array $managed_models = [
        Company::class,
    ];

    private static $page_length = 5;
}
