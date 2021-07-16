# Basic Image Gallery Page (& Multiple Gallery Holder Page)

## Introduction

Provides basic image gallery functionality to a SilverStripe site. 

Designed to provide a simple, fool-proof way for users to add image galleries to their website.

## Maintainer Contact ##
 * James Cocker (ssmodulesgithub@pswd.biz)
 
## Requirements
 * Silverstripe 4.1+
 
## Installation Instructions

1. Install:
````
composer require purplespider/purplespider/basic-galleries ^2
````

2. Visit yoursite.com/dev/build to rebuild the database.
3. Log in the CMS, and create a new Photo Gallery Holder page.
4. You can then create Photo Gallery Pages underneath this holder.
5. On a Photo Gallery Page, click on the Image Gallery tab, then click Bulk Upload to add images.

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