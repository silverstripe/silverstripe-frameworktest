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

Simply running `dev/build` will take care of most sample data setup.

In order to use any of the optional test behaviour targeted at modules,
install the module and remove the `_manifest_exclude` file from the relevant folder.
For example, to test the tagfield module, remove the `frameworktest/code/tagfield/_manifest_exclude` file.

## More sample data

The module creates some default pages for different CMS behaviours.
The CMS is intended to be perform well with a couple of thousand pages.
If you want to test the CMS behaviour for a large and nested tree, 
the module includes a simple generator task: `dev/tasks/FTPageMakerTask`.
It will create 3^5 pages by default, so takes a while to run through.

## Requirements

The module is intended to run against the latest core codebase,
but also includes branches matching earlier core releases for backwards compatibility.