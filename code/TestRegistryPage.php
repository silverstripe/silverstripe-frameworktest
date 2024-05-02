<?php

use SilverStripe\FrameworkTest\Model\TestPage;
use SilverStripe\ORM\DataObject;
use SilverStripe\Registry\RegistryPage;
use SilverStripe\Security\DefaultAdminService;
use SilverStripe\Security\Member;

if (class_exists(RegistryPage::class)) {
    class TestRegistryPage extends RegistryPage
    {
        public function requireDefaultRecords()
        {
            if (!DataObject::get_one(static::class)) {
                // Try to create common parent
                $defaultAdminService = DefaultAdminService::singleton();
                Member::actAs($defaultAdminService->findOrCreateDefaultAdmin(), function () {
                    $page = new static;
                    $page->Title = 'Registry Test Page';
                    $page->ShowInMenus = 0;
                    $parent = TestPage::getOrCreateParentPage();
                    $page->ParentID = $parent->ID;
                    $page->DataClass = TestRegistryDataObject::class;
                    $page->write();
                    $page->copyVersionToStage('Stage', 'Live');
                });
            }
        }
    }
}
