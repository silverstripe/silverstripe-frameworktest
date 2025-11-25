<?php

use SilverStripe\Admin\LeftAndMain;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormField;
use SilverStripe\Security\PermissionProvider;

class TestReactFormBuilder extends LeftAndMain implements PermissionProvider
{
    private static $url_segment = 'test-react';
    private static $menu_title = 'Test React FormBuilder';

    public function getClientConfig(): array
    {
        $baseLink = $this->Link();
        return array_merge(parent::getClientConfig(), [
            'reactRouter' => false,
            'form' => [
                'TestEditForm' => [
                    'schemaUrl' => $this->Link('schema/TestEditForm'),
                ],
            ]
        ]);
    }
    public function getTestEditForm($id = null) {
        /* @var $page BasicFieldsTestPage */
        $page = BasicFieldsTestPage::get()->First();
        $form = Form::create($this, 'TestEditForm', $page->getCMSFields(), FieldList::create([]));

        // Remove non-react fields
        $toRemove = [];
        $form->Fields()->recursiveWalk(function (FormField $field) use (&$toRemove) {
            $schemaData = $field->getSchemaData();
            if (!$schemaData['schemaType'] && !$schemaData['component']) {
                $toRemove[] = $field->getName();
            }
        });
        if (!empty($toRemove)) {
            $form->Fields()->removeByName($toRemove);
        }

        $form->loadDataFrom($page);
        return $form;
    }

    public function TestEditForm() {
        return $this->getTestEditForm();
    }

    /**
     * @todo Implement on client
     *
     * @param bool $unlinked
     * @return ArrayList
     */
    public function breadcrumbs($unlinked = false)
    {
        return null;
    }

    public function getEditForm($id = null, $fields = null) {
        Requirements::javascript('silverstripe/frameworktest: client/dist/js/legacy.js');

        return Form::create($this, 'TestEditForm', FieldList::create(), FieldList::create());
    }


    public function providePermissions()
    {
        $code = static::getRequiredPermissions();
        $title = LeftAndMain::menu_title(static::class);
        return [
            $code => [
                // Item in permission selection identifying the admin section. Example: Access to 'Files & Images'
                'name' => _t(
                    static::class . '.ACCESS',
                    "Access to '{title}' section",
                    ['title' => $title]
                ),
                'category' => _t(static::class . '.CMS_ACCESS_CATEGORY', 'CMS Access')
            ]
        ];
    }
}
