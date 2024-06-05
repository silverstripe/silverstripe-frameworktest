<?php

use DNADesign\Elemental\Models\ElementContent;
use SilverStripe\Assets\File;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Core\ClassInfo;
use SilverStripe\ElementalBannerBlock\Block\BannerBlock;
use SilverStripe\ElementalFileBlock\Block\FileBlock;
use SilverStripe\CMS\Model\SiteTree;
use DNADesign\Elemental\Extensions\ElementalPageExtension;
use DNADesign\Elemental\Models\BaseElement;

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
    ];

    /**
     * @var array Range of blocks to add (in case elemental is installed).
     * Will create between X and Y blocks randomly.
     */
    protected $blockCountRange = [
        1,
        10
    ];

    /**
     * @var array
     * @config
     */
    private static $block_generators = [
        'DNADesign\Elemental\Models\ElementContent' => [FTPageMakerTask::class, 'generateContentBlock'],
        'SilverStripe\ElementalBannerBlock\Block\BannerBlock' => [FTPageMakerTask::class, 'generateBannerBlock'],
        'SilverStripe\ElementalFileBlock\Block\FileBlock' => [FTPageMakerTask::class, 'generateFileBlock'],
    ];

    public function run($request)
    {
        // Optionally add blocks
        $withBlocks = (bool)$request->getVar('withBlocks');
        if ($withBlocks && !class_exists('DNADesign\Elemental\Models\BaseElement')) {
            throw new \LogicException('withBlocks requested, but BaseElement class not found');
        }

        // Allow pageCountByDepth to be passed as comma-separated value, e.g. pageCounts=5,100,1,1
        $pageCounts = $request->getVar('pageCounts');
        if ($pageCounts) {
            $counts = explode(',', $pageCounts ?? '');
            $this->pageCountByDepth = array_map(function ($int) {
                return (int) trim($int ?? '');
            }, $counts ?? []);
        }

        $this->generatePages(0, "", 0, $withBlocks);
    }

    protected function generatePages($depth = 0, $prefix = "", $parentID = 0, $withBlocks = false)
    {
        $maxDepth = count($this->pageCountByDepth ?? []);
        $pageCount = $this->pageCountByDepth[$depth];
        $testPageClasses = ClassInfo::implementorsOf('TestPageInterface');

        for ($i=1; $i<=$pageCount; $i++) {
            $fullPrefix = $prefix ? "{$prefix}-{$i}" : $i;
            $randomIndex = array_rand($testPageClasses ?? []);
            $pageClass = $testPageClasses[$randomIndex];
            $page = new $pageClass();
            $page->ParentID = $parentID;
            $page->Title = "Test page {$fullPrefix}";
            $page->write();
            $page->copyVersionToStage('Stage', 'Live');

            echo "Created '$page->Title' ($page->ClassName)\n";

            if ($withBlocks) {
                $this->generateBlocksForPage($page);
            }

            $pageID = $page->ID;

            unset($page);

            if ($depth < $maxDepth-1) {
                $this->generatePages($depth+1, $fullPrefix, $pageID, $withBlocks);
            }
        }
    }

    protected function generateBlocksForPage(Page $page)
    {
        $classes = array_filter($this->config()->get('block_generators') ?? [], function ($callable, $class) {
            return class_exists($class ?? '');
        }, ARRAY_FILTER_USE_BOTH);

        // Generate a random amount of blocks in the preferred range
        $range = $this->blockCountRange;
        foreach(range($range[0], array_rand(range($range[0], $range[1]))) as $i) {
            $class = array_rand($classes ?? []);
            $callable = $classes[$class];
            $block = call_user_func($callable, $page);

            // Add block to page
            $page->ElementalArea()->Elements()->add($block);

            // 50% chance of block being published
            if (rand(0,1) === 0) {
                $block->publishRecursive();
            }

            echo sprintf("  Added '%s' block #%d to page #%d\n", $class, $block->ID, $page->ID);
        }
    }

    /**
     * @param SiteTree&ElementalPageExtension|null $page
     * @return ElementContent
     * @throws \SilverStripe\ORM\ValidationException
     */
    public static function generateContentBlock(?SiteTree $page = null)
    {
        $count = $page ? $page->ElementalArea()->Elements()->count() : '';
        $content = $page ? "Page {$page->Title}" : "Page";
        $block = new ElementContent([
            'Title' => sprintf('Block #%s (Content Block)', $count),
            'ShowTitle' => rand(0,1) === 1,
            'HTML' => sprintf('Content block for <bold>%s</bold>', $content),
        ]);
        $block->write();

        return $block;
    }

    /**
     * @param SiteTree&ElementalPageExtension|null $page
     * @return FileBlock
     * @throws \SilverStripe\ORM\ValidationException
     */
    public static function generateFileBlock(?SiteTree $page = null): FileBlock
    {
        $count = $page ? $page->ElementalArea()->Elements()->count() : '';

        // Supports both images and files
        $file = File::get()->shuffle()->First();
        if (!$file) {
            throw new \LogicException('No files found to associate with FileBlock');
        }

        $block = new FileBlock([
            'Title' => sprintf('Block #%s (File Block)', $count),
            'ShowTitle' => rand(0,1) === 1,
        ]);
        $block->FileID = $file->ID;
        $block->write();

        return $block;
    }

    /**
     * @param SiteTree&ElementalPageExtension|null $page
     * @return BannerBlock
     * @throws \SilverStripe\ORM\ValidationException
     */
    public static function generateBannerBlock(?SiteTree $page = null): BannerBlock
    {
        $count = $page ? $page->ElementalArea()->Elements()->count() : '';
        $content = $page ? "Page {$page->Title}" : "Page";

        $block = new BannerBlock([
            'Title' => sprintf('Block #%s (Banner Block)', $count),
            'ShowTitle' => rand(0,1) === 1,
            'Content' => sprintf('Banner block for <bold>%s</bold>', $content),
            'CallToActionLink' => json_encode([
                'PageID' => SiteTree::get()->shuffle()->first()->ID,
                'Text' => sprintf('Link for page %s', $page->Title),
            ]),
        ]);
        $block->write();

        return $block;
    }

}
