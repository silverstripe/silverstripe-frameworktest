<?php

use SilverStripe\Dev\SapphireTest;

class FTPageTypeCreatorTaskTest extends SapphireTest
{
    protected function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('FTPageTypeCreatorTaskTest'));
    }

    public function testGeneratesFiles()
    {
        $task = new FTPageTypeCreatorTask();
        $result = $task->run(new \SilverStripe\Control\HTTPRequest('GET', ''));
        $path = $task->getTargetPath();
        $this->assertTrue(vfsStreamWrapper::getRoot()->getChildren());
    }
}