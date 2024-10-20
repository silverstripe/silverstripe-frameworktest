<?php

use SilverStripe\Admin\LeftAndMain;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;

class TestReactFormBuilder extends LeftAndMain
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
}
