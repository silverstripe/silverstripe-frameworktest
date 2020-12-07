<?php

use DNADesign\Elemental\Models\ElementContent;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Core\ClassInfo;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\ElementalBannerBlock\Block\BannerBlock;
use SilverStripe\ElementalFileBlock\Block\FileBlock;


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
        'DNADesign\Elemental\Models\ElementContent' => [self::class, 'generateContentBlock'],
        'SilverStripe\ElementalBannerBlock\Block\BannerBlock' => [self::class, 'generateBannerBlock'],
        'SilverStripe\ElementalFileBlock\Block\FileBlock' => [self::class, 'generateFileBlock'],
    ];

    public function run($request)
    {
        // Optionally add blocks
        $withBlocks = (bool)$request->getVar('withBlocks');
        if ($withBlocks && !class_exists('DNADesign\Elemental\Models\BaseElement')) {
            throw new \LogicException('withBlocks requested, but BaseElement class not found');
        }

        $this->generatePages(0, "", 0, $withBlocks);
    }

    protected function generatePages($depth = 0, $prefix = "", $parentID = 0, $withBlocks = false)
    {
        $maxDepth = count($this->pageCountByDepth);
        $pageCount = $this->pageCountByDepth[$depth];
        $testPageClasses = ClassInfo::implementorsOf('TestPageInterface');

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
        $classes = array_filter($this->config()->get('block_generators'), function ($callable, $class) {
            return class_exists($class);
        }, ARRAY_FILTER_USE_BOTH);

        // Generate a random amount of blocks in the preferred range
        $range = $this->blockCountRange;
        foreach(range($range[0], array_rand(range($range[0], $range[1]))) as $i) {
            $class = array_rand($classes);
            $callable = $classes[$class];
            $block = call_user_func($callable);

            // Add block to page
            $page->ElementalArea()->Elements()->add($block);

            // 50% chance of block being published
            if (rand(0,1) === 0) {
                $block->publishRecursive();
            }

            echo sprintf("  Added '%s' block #%d to page #%d\n", $class, $block->ID, $page->ID);
        }
    }

    public static function generateContentBlock()
    {
        $block = new ElementContent([
            'HTML' => '<bold>test</bold> 123'
        ]);
        $block->write();

        return $block;
    }

    public static function generateFileBlock()
    {
        // Supports both images and files
        $file = File::get()->shuffle()->First();
        if (!$file) {
            throw new \LogicException('No files found to associate with FileBlock');
        }

        $block = new FileBlock();
        $block->FileID = $file->ID;
        $block->write();

        return $block;
    }

    public static function generateBannerBlock()
    {
        $block = new BannerBlock([
            'Content' => '<bold>test</bold> 123',
            'CallToActionLink' => 'http://example.com',
        ]);
        $block->write();

        return $block;
    }

}
