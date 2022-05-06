<?php

namespace SilverStripe\FrameworkTest\Model;

use SilverStripe\FrameworkTest\Admin\TestBlogPostsAdmin;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataObject;

class TestBlogPost extends DataObject
{
    private static string $table_name = 'TestBlogPost';

    public function CMSEditLink()
    {
        $admin = TestBlogPostsAdmin::singleton();
        $sanitisedClassname = str_replace('\\', '-', $this->ClassName);

        return Controller::join_links(
            $admin->Link($sanitisedClassname),
            'EditForm/field/',
            $sanitisedClassname,
            'item',
            $this->ID,
        );
    }
}
