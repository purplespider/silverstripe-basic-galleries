# Basic Image Galleries Module

## Introduction

Provides basic image gallery functionality to a SilverStripe site. 

Designed to provide a simple, fool-proof way for users to add image galleries to their website.

This module has been designed to have just the minimum required features, to avoid bloat, but can be easily extended to add new fields if required.

## Maintainer Contact ##
 * James Cocker (ssmodulesgithub@pswd.biz)
 
## Requirements
 * Silverstripe 4.1+
 * Use the 1.0 branch for SilverStripe 3.1 support
 
## Installation Instructions

1. Place the contents of this repository in a directory named *basic-galleries* at the root of your SilverStripe install.
2. Visit yoursite.com/dev/build to rebuild the database.
3. Log in the CMS, and create a new Photo Gallery Holder page.
4. You can then create Photo Gallery Pages underneath this holder.
5. On a Photo Gallery Page, click on the Image Gallery tab, then click Bulk Upload to add images.

## Config

The Extension can be applied to any page type to enable the gallery functionality.

You can also customise the CMS tab that the gallery appears on, as well as the title of the gallery displayed in the CMS:

````
HomePage:
  extensions:
    - PurpleSpider\BasicGalleries\PhotoGalleryExtension
  gallery-title: Image Gallery
  gallery-cms-tab: Main
````