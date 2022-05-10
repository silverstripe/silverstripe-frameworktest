<?php

namespace SilverStripe\FrameworkTest\Elemental\Extension;

use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\ORM\DataExtension;

class ElementalBehatTestExtension extends DataExtension
{
    private static $has_one = [
        'ElementalArea' => ElementalArea::class,
    ];

    private static $owns = ['ElementalArea'];
}
