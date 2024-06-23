<?php

namespace SilverStripe\FrameworkTest\Elemental\Model;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\SearchableDropdownField;
use SilverStripe\Forms\SearchableMultiDropdownField;
use SilverStripe\FrameworkTest\Model\Company;

if (!class_exists(BaseElement::class)) {
    return;
}

class ElementalSearchableFieldsBlock extends BaseElement
{
    private static $table_name = 'ElementalSearchableFieldsBlock';

    private static string $singular_name = 'SearchableFields Block';

    private static string $plural_name = 'SearchableFields Blocks';

    private static $has_one = [
        'Company' => Company::class,
    ];

    private static $many_many = [
        'Companys' => Company::class,
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('CompanyID');
        $fields->addFieldToTab('Root.Main', SearchableDropdownField::create(
            'CompanyID',
            'Company',
            Company::get()
        )
            ->setLabelField('Name')
            ->setIsLazyLoaded(true)
        );
        $fields->addFieldToTab('Root.Main', SearchableMultiDropdownField::create(
            'Companys',
            'Companys',
            Company::get()
        )
            ->setLabelField('Name')
            ->setIsLazyLoaded(true)
        );
        return $fields;
    }
}
