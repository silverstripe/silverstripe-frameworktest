<?php

use DNADesign\Elemental\Extensions\ElementalPageExtension;

class BasicElementalPage extends Page
{
    private static $extensions = [
        ElementalPageExtension::class,
    ];
}
