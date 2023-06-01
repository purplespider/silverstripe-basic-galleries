# Basic Image Gallery Page (& Multiple Gallery Holder Page) for Silverstripe

## Introduction

Provides basic image gallery functionality to a Silverstripe site.

Designed to provide a simple, fool-proof way for users to add image galleries to their website.

Applies [Basic Image Gallery Extension
](https://github.com/purplespider/silverstripe-basic-gallery-extension) to a `PhotoGalleryPage` page type, and includes a `PhotoGalleryHolder` type.

## Maintainer Contact

-   James Cocker (ssmodulesgithub@pswd.biz)

## Requirements

-   Silverstripe 5

## Installation Instructions

1. Install:
   Until [this PR](https://github.com/colymba/GridFieldBulkEditingTools/pull/238) is merged:
   Add to composer.json:

    ```
        "repositories": [
    		{
    			"type": "vcs",
    			"url": "https://github.com/purplespider/GridFieldBulkEditingTools"
    		}
    	],
    ```

    Add to `require`:

    ```
    "colymba/gridfield-bulk-editing-tools": "dev-ss5-fix-json2array as 4.0",
    ```

    Then install this module:

    ```
    composer require purplespider/basic-galleries ^3


    ```

2. Visit yoursite.com/dev/build to rebuild the database.
3. Log in the CMS, and create a new Photo Gallery Holder page.
4. You can then create Photo Gallery Pages underneath this holder.
5. On a Photo Gallery Page, click on the Image Gallery tab, then click Bulk Upload to add images.

## Screenshot

<img width="1277" alt="Screenshot 2021-07-16 at 13 15 28@2x" src="https://user-images.githubusercontent.com/329880/125945926-12f45da8-ec7a-4851-927c-c8dddee461af.png">

## Config

You can customise the CMS tab that the gallery appears on, as well as the title of the gallery displayed in the CMS:

```

HomePage:
extensions: - PurpleSpider\BasicGalleries\PhotoGalleryExtension
gallery-title: Image Gallery
gallery-cms-tab: Main

```

### Automatically Delete Image Files

To automatically delete image files when an image is deleted from a gallery:

```yml
---
Name: custom-basic-gallery-extension
After: basic-gallery-extension
---
PurpleSpider\BasicGalleryExtension\PhotoGalleryImage:
    ondelete_delete_image_files: true
```

This uses [Delete Asset If Unused Extension](https://github.com/purplespider/asset-delete-if-unused-extension) to detect if the image is being used elsewhere on the site, and will only delete it if it isn't. There are caveats though, so check this module's readme, i.e. you might not want to use this on sites that have been upgraded from Silverstripe 3.

## Version Details

-   0.\* = SilverStripe 3
-   1.\* = Silverstripe 4
-   2.\* = Silverstripe 4 (Uses newer version of `PhotoGalleryExtension` with a polymorphic relation, so upgrading from 1 to 2 will break existing galleries.)
-   3.\* = Silverstripe 5

## Upgrade Notes

### To v1 or higher (extension moved to seperate module)

-   Change any references to the extension, e.g. if applied to the Homepage type, from `PurpleSpider\BasicGalleries\PhotoGalleryExtension` to `PurpleSpider\BasicGalleryExtension\PhotoGalleryExtension`
-   `PurpleSpider\BasicGalleries\PhotoGalleryImage` is now `PurpleSpider\BasicGalleryExtension\PhotoGalleryImage` (in case you applied your own extension to it)
-   Run dev/build to update table names automatically (via legacy.yml)

## to v2 or higher (individual page and elemental relations changed to a single polymorphic relation)

-   Complete "To v1" upgrade instructions, inc `dev/build`
-   Run `/dev/tasks/upgrade-basic-galleries` script to update database for existing galleries.

## to v3 (Silverstripe 5)

-   Nothing extra required, just change version to `^3` and note above re extra repository.
