<?php

namespace SilverStripe\FrameworkTest\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\FrameworkTest\Model\TestBlogPost;

class TestBlogPostsAdmin extends ModelAdmin
{
    private static string $url_segment = 'test-blog-posts-admin';
    private static string $menu_title = 'Blog Posts';
    private static string $menu_icon_class = 'font-icon-block-banner';

    private static array $managed_models = [
        TestBlogPost::class,
    ];
}
