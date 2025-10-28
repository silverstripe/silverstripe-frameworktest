<?php

namespace SilverStripe\FrameworkTest\Accessibility\Code;

use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TabSet;

class LiteralFieldPageExtension extends Extension
{
    protected function updateCMSFields(FieldList &$fields): void
    {
        $fields = new FieldList([new TabSet('Root')]);
        $fields->addFieldToTab(
            'Root.Main',
            new LiteralField('lf01', '<p id="lf01">Nothing to focus on</p>')
        );
    }
}
