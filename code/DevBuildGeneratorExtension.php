<?php

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Extension;

/**
 * There is no good place to put this setting, so it gets a class.
 */
class DevBuildGeneratorExtension extends Extension
{
    use Configurable;

    private static $regenerate_on_build = false;
}
