<?php

namespace SilverStripe\FrameworkTest\GridFieldArbitraryData;

use RuntimeException;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use SilverStripe\Forms\GridField\GridFieldViewButton;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\ORM\Search\BasicSearchContext;
use SilverStripe\Model\ArrayData;

class ArbitraryDataAdmin extends LeftAndMain
{
    public const TAB_ARRAYDATA = 'arraydata';

    public const TAB_CUSTOM_MODEL = 'custommodel';

    private static $url_segment = 'arbitrary-data';

    private static $menu_title = 'Arbitrary Data Gridfield';

    private static $url_rule = '/$Tab/$Action';

    private static $url_handlers = [
        '$Tab/$Action' => 'handleAction'
    ];

    private ?string $tab = null;

    private static int $num_initial_items = 30;

    /**
     * Directly copied from ModelAdmin with minor tweaks
     */
    protected function init()
    {
        parent::init();

        $this->tab = $this->getRequest()->param('Tab');

        // accessing the admin directly
        if ($this->tab === null) {
            $this->tab = ArbitraryDataAdmin::TAB_ARRAYDATA;
        }

        if ($this->tab !== ArbitraryDataAdmin::TAB_ARRAYDATA && $this->tab !== ArbitraryDataAdmin::TAB_CUSTOM_MODEL) {
            throw new RuntimeException("Unexpected url segment: {$this->tab}");
        }
    }

    public function getList()
    {
        $list = ArrayList::create();

        switch ($this->tab) {
            case ArbitraryDataAdmin::TAB_ARRAYDATA:
                foreach (ArbitraryDataAdmin::getInitialRecords() as $stub) {
                    $list->add(ArrayData::create($stub));
                }
                break;
            case ArbitraryDataAdmin::TAB_CUSTOM_MODEL:
                $rawData = SQLSelect::create()->setFrom(ArbitraryDataModel::TABLE_NAME)->execute();
                foreach ($rawData as $record) {
                    $list->add(ArbitraryDataModel::create($record));
                }
                $list->setDataClass(ArbitraryDataModel::class);
                break;
            default:
                throw new RuntimeException("Unexpected tab: {$this->tab}");
        }

        $this->extend('updateList', $list);

        return $list;
    }

    public static function getInitialRecords()
    {
        $numRecords = static::config()->get('num_initial_items');
        $records = [];
        for ($id = 1; $id <= $numRecords; $id++) {
            $records[] = [
                'ID' => $id,
                'Title' => "item $id",
            ];
        }
        return $records;
    }

    protected function getGridFieldConfig(): GridFieldConfig
    {
        if ($this->tab === ArbitraryDataAdmin::TAB_CUSTOM_MODEL) {
            $config = GridFieldConfig_RecordEditor::create();
        } else {
            // This is effectively the same as a GridFieldConfig_RecordViewer, but without removing the GridFieldFilterHeader.
            $config = GridFieldConfig_Base::create();
            $config->addComponent(GridFieldViewButton::create());
            $config->addComponent(GridFieldDetailForm::create());
            $fieldNames = array_keys(ArbitraryDataAdmin::getInitialRecords()[0]);
            $config->getComponentByType(GridFieldDataColumns::class)->setDisplayFields(array_combine($fieldNames, $fieldNames));
            $fields = array_map(fn ($name) => $name === 'ID' ? HiddenField::create($name) : TextField::create($name), $fieldNames);
            $config->getComponentByType(GridFieldDetailForm::class)->setFields(FieldList::create($fields));
            $searchContext = BasicSearchContext::create(ArrayData::class);
            $searchFields = array_map(
                fn ($name) => $name === 'ID'
                    ? HiddenField::create(BasicSearchContext::config()->get('general_search_field_name'))
                    : TextField::create($name),
                $fieldNames
            );
            $searchContext->setFields(FieldList::create($searchFields));
            $config->getComponentByType(GridFieldFilterHeader::class)->setSearchContext($searchContext);
        }

        $config->getComponentByType(GridFieldPaginator::class)->setItemsPerPage(10);

        $exportButton = GridFieldExportButton::create('buttons-before-left');
        // $exportButton->setExportColumns($this->getExportFields());

        $config->addComponents([
            $exportButton,
            GridFieldPrintButton::create('buttons-before-left')
        ]);

        $this->extend('updateGridFieldConfig', $config);

        return $config;
    }

    /**
     * Directly copied from ModelAdmin with minor tweaks
     */
    protected function getGridField(): GridField
    {
        $field = GridField::create(
            $this->tab,
            false,
            $this->getList(),
            $this->getGridFieldConfig()
        );

        $this->extend('updateGridField', $field);

        return $field;
    }

    /**
     * Directly copied from ModelAdmin with minor tweaks
     */
    public function getEditForm($id = null, $fields = null)
    {
        $form = Form::create(
            $this,
            'EditForm',
            FieldList::create($this->getGridField()),
            FieldList::create()
        )->setHTMLID('Form_EditForm');

        $form->addExtraClass('cms-edit-form cms-panel-padded center flexbox-area-grow');
        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));
        $editFormAction = Controller::join_links($this->Link($this->tab), 'EditForm');
        $form->setFormAction($editFormAction);
        $form->setAttribute('data-pjax-fragment', 'CurrentForm');

        $this->extend('updateEditForm', $form);

        return $form;
    }

    /**
     * Directly copied from ModelAdmin with minor tweaks
     */
    protected function getManagedTabs()
    {
        $tabs = [
            ArbitraryDataAdmin::TAB_ARRAYDATA => 'ArrayData',
            ArbitraryDataAdmin::TAB_CUSTOM_MODEL => 'Custom Model',
        ];
        $forms = new ArrayList();

        foreach ($tabs as $tab => $title) {
            $forms->push(new ArrayData([
                'Title' => $title,
                'Tab' => $tab,
                'Link' => $this->Link($tab),
                'LinkOrCurrent' => ($tab === $this->tab) ? 'current' : 'link'
            ]));
        }

        return $forms;
    }

    /**
     * Directly copied from ModelAdmin with minor tweaks
     */
    public function Link($action = null)
    {
        if (!$action) {
            $action = $this->tab;
        }
        return parent::Link($action);
    }

    /**
     * Directly copied from ModelAdmin with minor tweaks
     */
    public function Breadcrumbs($unlinked = false)
    {
        $items = parent::Breadcrumbs($unlinked);

        // Show the class name rather than ModelAdmin title as root node
        $params = $this->getRequest()->getVars();
        if (isset($params['url'])) {
            unset($params['url']);
        }

        $items[0]->Title = $this->tab;
        $items[0]->Link = Controller::join_links(
            $this->Link($this->tab),
            '?' . http_build_query($params ?? [])
        );

        return $items;
    }
}
