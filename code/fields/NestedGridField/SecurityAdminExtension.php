<?php

namespace SilverStripe\FrameworkTest\Fields\NestedGridField;

use SilverStripe\Core\Extension;
use SilverStripe\Security\Group;
use Symbiote\GridFieldExtensions\GridFieldNestedForm;

class SecurityAdminExtension extends Extension
{
    protected function updateGridFieldConfig($config)
    {
        if ($this->owner->getModelClass() === Group::class) {
          $config->addComponent(GridFieldNestedForm::create()->setRelationName('Members'));
        }
    }
}
