<?php

namespace SilverStripe\FrameworkTest\SudoMode;

use RuntimeException;
use SilverStripe\Forms\Form;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Member;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\ArrayList;

/**
 * Extension that adds Member relations on a page to test that sudo-mode
 * works on gridfields for relations
 *
 * @extends Extension<Form>
 */
class MemberRelationsPageExtension extends Extension
{
    private static $has_many = [
        'HasManyMembers' => Member::class
    ];

    private static $many_many = [
        'ManyManyMembers' => Member::class
    ];

    public function updateCMSFields(&$fields)
    {
        $gridField = new GridField('HasManyMembers', 'HasManyMembers', $this->owner->HasManyMembers());
        $config = GridFieldConfig_RecordEditor::create();
        $gridField->setConfig($config);
        $fields->insertAfter('Title', $gridField);
        // Intentionally using an ArrayList here to check that the gridfield can handle it
        $list = new ArrayList($this->owner->ManyManyMembers()->toArray());
        $gridField = new GridField('ManyManyMembers', 'ManyManyMembers', $list);
        $config = GridFieldConfig_RecordEditor::create();
        $gridField->setConfig($config);
        $fields->insertAfter('Title', $gridField);
        return $fields;
    }

    protected function onBeforeWrite()
    {
        $member = Member::get()->first();
        if (!$member) {
            throw new RuntimeException('No Member record found, create one in your test setup');
        }
        if ($this->owner->HasManyMembers()->count() === 0) {
            $this->owner->HasManyMembers()->add($member);
        }
        if ($this->owner->ManyManyMembers()->count() === 0) {
            $this->owner->ManyManyMembers()->add($member);
        }
    }
}
