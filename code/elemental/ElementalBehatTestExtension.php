<?php

namespace SilverStripe\FrameworkTest\Elemental\Extension;

use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\Core\Extension;

class ElementalBehatTestExtension extends Extension
{
    private static $has_one = [
        'ElementalArea' => ElementalArea::class,
    ];

    private static $owns = ['ElementalArea'];
}
