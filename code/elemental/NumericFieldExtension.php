<?php

namespace SilverStripe\FrameworkTest\Elemental\Extension;

use SilverStripe\Forms\NumericField;
use SilverStripe\Core\Extension;

/**
 * @extends Extension<NumericField>
 */
class NumericFieldExtension extends Extension
{
    protected function updateValidationResult($result, $validator)
    {
        if ($this->owner->Value() == 1) {
            $validator->validationError($this->owner->getName(), 'This field cannot be 1');
        }
    }
}
