<?php

use SilverStripe\Dev\BuildTask;
use SilverStripe\Core\ClassInfo;

/**
 * Creates sample page structure, useful to test tree performance,
 * UI behaviour on deeply nested pages etc.
 * 
 * @todo Allow passing in counts
 */
class FTPageMakerTask extends BuildTask
{
    
    /**
     * Defaults create 2,000 pages
     */
    protected $pageCountByDepth = [
        5,
        100,
        1,
        1,
        1
    ];

    public function run($request)
    {
        $this->generatePages();
    }

    protected function generatePages($depth = 0, $prefix = "", $parentID = 0)
    {
        $maxDepth = count($this->pageCountByDepth);
        $pageCount = $this->pageCountByDepth[$depth];
        $testPageClasses = ClassInfo::implementorsOf('TestPageInterface');
        $testPageClasses[] = 'Page';

        for ($i=1; $i<=$pageCount; $i++) {
            $fullPrefix = $prefix ? "{$prefix}-{$i}" : $i;
            $randomIndex = array_rand($testPageClasses);
            $pageClass = $testPageClasses[$randomIndex];
            $page = new $pageClass();
            $page->ParentID = $parentID;
            $page->Title = "Test page {$fullPrefix}";
            $page->write();
            $page->publish('Stage', 'Live');

            echo "Created '$page->Title' ($page->ClassName)\n";
            
            $pageID = $page->ID;
            unset($page);

            if ($depth < $maxDepth-1) {
                $this->generatePages($depth+1, $fullPrefix, $pageID);
            }
        }
    }
    
}
