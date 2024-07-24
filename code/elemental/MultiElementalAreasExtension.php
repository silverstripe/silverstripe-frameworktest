<?php

namespace SilverStripe\FrameworkTest\Elemental\Extension;

use DNADesign\Elemental\Extensions\ElementalAreasExtension;
use DNADesign\Elemental\Models\ElementalArea;

/**
 * This is used to test multiple elemental areas on a page
 */
class MultiElementalAreasExtension extends ElementalAreasExtension
{
    private static $has_one = [
        'ElementalArea1' => ElementalArea::class,
        'ElementalArea2' => ElementalArea::class
    ];

    private static $owns = [
        'ElementalArea1',
        'ElementalArea2'
    ];
}
