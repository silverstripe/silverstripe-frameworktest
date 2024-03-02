<?php

namespace SilverStripe\FrameworkTest\LinkField\Blocks;

use DNADesign\Elemental\Models\BaseElement;

class LinkFieldTestBlock extends BaseElement
{
    private static string $table_name = 'LinkFieldTestBlock';

    private static string $icon = 'font-icon-block-file-list';

    private static string $singular_name = 'Links List Block';

    private static string $plural_name = 'Links List Blocks';
}
