# Framework Test Module

## Introduction

Aids core and module developers in testing their code against
a set of sample data and behaviour.

 * Shows all core form fields, including their disabled and readonly state
 * Shows sample GridField instance including data
 * Creates sample members (to efficiently test SecurityAdmin)
 * Creates a sample ModelAdmin instance (available at `admin/test`)
 * (Optional) Three-step process for the [multiform](http://www.silverstripe.org/multi-form-module/) module
 * (Optional) Sample page for the [tagfield](http://www.silverstripe.org/tag-field-module/) module
 * (Optional) Sample page for the [recaptcha](http://www.silverstripe.org/recaptcha-module/) module

## Usage

Simply running `sake db:build` will take care of most sample data setup.

In order to use any of the optional test behaviour targeted at modules,
install the module and remove the `_manifest_exclude` file from the relevant folder.
For example, to test the tagfield module, remove the `frameworktest/code/tagfield/_manifest_exclude` file.

## More sample data

The module creates some default pages for different CMS behaviours.
The CMS is intended to be perform well with a couple of thousand pages.
If you want to test the CMS behaviour for a large and nested tree,
the module includes a simple generator task: `sake tasks:FTPageMakerTask`.
It will create 3^5 pages by default, so takes a while to run through.

## Configuring the amount of data

Both `FTPageMagerTask` and `FTFileMakerTask` allow the amount of generated content to be configured.
To do this, pass a comma-seprarated list of integers representing the amount of records to create at each
depth.

`$ vendor/bin/sake tasks:FTPageMakerTask --pageCounts=10,200,5,5`

`$ vendor/bin/sake tasks:FTFileMakerTask --fileCounts=5,300,55,5 --folderCounts=1,5,5,5`

## Guaranteed unique images

The `FTFileMakerTask` will randomly watermark each reference to your images by default. If you want to disable this,
set the `uniqueImages` config variable to `false`.

## Blocks

When [dnadesign/silverstripe-elemental](https://github.com/dnadesign/silverstripe-elemental)
is installed, the `FTPageMakerTask` can also generate blocks within those pages automatically.
It has a few hardcoded sample data structures for common block types,
and randomly creates a number of blocks, as well as randomly choosing to publish them.
Relies on files and images being available to add as sample data.

Additional setup:

```
composer require dnadesign/silverstripe-elemental
composer require silverstripe/elemental-bannerblock
composer require silverstripe/elemental-fileblock
```

Usage:

```
# Generate some sample files to associate with blocks
sake tasks:FTFileMakerTask
sake tasks:FTPageMakerTask withBlocks=true
```

## Requirements

The module is intended to run against the latest core codebase,
but also includes branches matching earlier core releases for backwards compatibility.

## Related

 * [zframeworktest_dbswitcher](https://github.com/silverstripe-labs/zframeworktest_dbswitcher) module - adds capabilities to switch the database by a query parameter for testing purposes
