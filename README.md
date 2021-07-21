# Basic Image Gallery Page (& Multiple Gallery Holder Page)

## Introduction

Provides basic image gallery functionality to a SilverStripe site. 

Designed to provide a simple, fool-proof way for users to add image galleries to their website.

Applies [Basic Image Gallery Extension
](https://github.com/purplespider/silverstripe-basic-gallery-extension) to a `PhotoGalleryPage` page type, and includes a `PhotoGalleryHolder` type.

## Maintainer Contact ##
 * James Cocker (ssmodulesgithub@pswd.biz)
 
## Requirements
 * Silverstripe 4.1+
 
## Installation Instructions

1. Install:
````
composer require purplespider/basic-galleries ^2
````

2. Visit yoursite.com/dev/build to rebuild the database.
3. Log in the CMS, and create a new Photo Gallery Holder page.
4. You can then create Photo Gallery Pages underneath this holder.
5. On a Photo Gallery Page, click on the Image Gallery tab, then click Bulk Upload to add images.

## Screenshot
<img width="1277" alt="Screenshot 2021-07-16 at 13 15 28@2x" src="https://user-images.githubusercontent.com/329880/125945926-12f45da8-ec7a-4851-927c-c8dddee461af.png">

## Config

You can customise the CMS tab that the gallery appears on, as well as the title of the gallery displayed in the CMS:

````
HomePage:
  extensions:
    - PurpleSpider\BasicGalleries\PhotoGalleryExtension
  gallery-title: Image Gallery
  gallery-cms-tab: Main
````

## Version Details

* 0.* = Silverstripe 3
* 1.* = Silverstripe 4
* 2.* = Silverstripe 4 (Uses newer version of `PhotoGalleryExtension` with a polymorphic relation, so upgrading from 1 to 2 will break existing galleries.)

## Upgrade Notes
### To v1 (extension moved to seperate module)
* Change any references to the extension, e.g. if applied to the Homepage type, from `PurpleSpider\BasicGalleries\PhotoGalleryExtension` to `PurpleSpider\BasicGalleryExtension\PhotoGalleryExtension`
* `PurpleSpider\BasicGalleries\PhotoGalleryImage` is now `PurpleSpider\BasicGalleryExtension\PhotoGalleryImage` (in case you applied your own extension to it)
* Run dev/build to update table names automatically (via legacy.yml)
## to v2 (individual page and elemental relations changed to a single polymorphic relation)
* Complete "To v1" upgrade instructions, inc `dev/build`
* Run `/dev/tasks/upgrade-basic-galleries` script to update database for existing galleries.
