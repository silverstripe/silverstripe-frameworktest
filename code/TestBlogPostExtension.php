<?php

namespace SilverStripe\FrameworkTest\Extension;

use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\ORM\DataExtension;

class TestBlogPostExtension extends DataExtension
{
    private static $has_one = [
        'ElementalArea' => ElementalArea::class,
    ];

    private static $owns = ['ElementalArea'];
}
