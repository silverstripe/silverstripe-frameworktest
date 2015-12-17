<?php
/**
 * Creates sample page structure, useful to test tree performance,
 * UI behaviour on deeply nested pages etc.
 * 
 * @todo Allow passing in counts
 */
class FTPageMakerTask extends BuildTask
{
    

    public function run($request)
    {
        echo "<h1>Making pages</h1>";
        // Creates 3^5 pages
        $this->makePages(3, 5);
    }
    
    protected function makePages($count, $depth, $prefix = "", $parentID = 0)
    {
        for ($i=1;$i<=$count;$i++) {
            $page = new Page();
            $page->ParentID = $parentID;
            $page->Title = "Test page $prefix$i";
            $page->write();
            $page->publish('Stage', 'Live');

            echo "<li>Created '$page->Title'";
            if ($depth > 1) {
                $this->makePages($count, $depth-1, $prefix."$i.", $page->ID);
            }
        }
    }
}
