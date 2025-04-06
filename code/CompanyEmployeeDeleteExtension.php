<?php

namespace SilverStripe\FrameworkTest\Model;

use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Extension;

/**
 * Extension to have a delete action on the Company Employee GridField, rather than an unlink action
 */
class CompanyEmployeeDeleteExtension extends Extension
{
    public function updateCMSFields(FieldList $fields)
    {
        $gridField = $fields->dataFieldByName('Employees');
        $config = $gridField->getConfig();
        $config->removeComponentsByType(GridFieldDeleteAction::class);
        $config->addComponent(new GridFieldDeleteAction(false));
    }
}
