<?php

use SilverStripe\Core\Config\Configurable;
use SilverStripe\ORM\DataExtension;

/**
 * There is no good place to put this setting, so it gets a class.
 */
class DevBuildGeneratorExtension extends DataExtension
{
    use Configurable;

    private static $regenerate_on_build = false;
}
