<?php

namespace SilverStripe\FrameworkTest\Fields\NestedGridField;

use RuntimeException;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldNestedForm;

class NestedGridFieldAdmin extends ModelAdmin
{
    private static string $url_segment = 'nested-gridfield-section';
    private static string $menu_title = 'Nested GridField Section';
    private static string $menu_icon_class = 'font-icon-block-banner';

    private static array $managed_models = [
        'root-nodes' => [
            'title' => 'Root Nodes',
            'dataClass' => RootNode::class,
        ],
        'non-relational-data' => [
            'title' => 'Non-Relational Data',
            'dataClass' => NonRelationalData::class,
        ],
    ];

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config = parent::getGridFieldConfig();
        if ($this->modelClass === RootNode::class) {
            $config->addComponent(GridFieldNestedForm::create()->setRelationName('BranchNodes'));
        } else if ($this->modelClass === NonRelationalData::class) {
            $config->addComponent(GridFieldNestedForm::create()->setRelationName('getList'));
        } else {
            throw new RuntimeException("Unexpected Model name: {$this->tab}");
        }

        return $config;
    }
}
