# Silverstripe Brand module

A module to assist with a website's basic branding. Allows setting of brand colours and fonts from within a Silverstripe Admin.

## Requirements

SilverStripe 4 or higher. See 3.0 branch for SilverStripe 3 support

## Installation

``composer require adrexia/brand``

## Setup
You can either just include the Favicons, and apply the colour schemes manually:
``<% include Adrexia/Brand/Favicons %>``

Or, include the brand template in the head of you page template to get both:  
``<% include Adrexia/Brand/Brand %>``

By default this includes the fonts, the font-colors, and the favicons.
The Menu colours are left for you to implement, or disable based on your site's requirements. 
The Palette colours are for use on other page types, or for custom theming. For example, they can be used to add a restricted colourpalette to a page (with the help of the Color Palette module):

    $brand = Brand::get()->First();

    if($brand) {
        $fields->insertAfter(
            ColorPaletteField::create(
                "Color", "Color", $brand->getFullPalette()
            ), "Intro"
        );
    }

There is an extension 'BrandDataObjectExtension' included for this purpose which adds a brand colour, a contrast colour, and an image. To enable it, add this to your _config.yml file:

    Page:
      extensions:
       - Adrexia\Brand\BrandDataObjectExtension

The other variables provided can be called in a template with:  
``$Brand.Logo``   
``$Brand.BodyBackgroundColour``

To get the hex value of a colour from a colourpalette in your template you can do something like this:

    <% if $Colour %>$Brand.getHex($Color)<% else %>$Brand.getHex($Level(1).Color)<% end_if %>

## Subsite support
NOTE: Subsite support isn't yet complete for silverstripe 4

This module can work with subsites with the addition of the SubsiteModelExtension from adrexia/subsite-modeladmins (specifically, the onBeforeWrite and augmentSQL functions). You can install this via composer require, or just take the bits you need:

``composer require adrexia/subsite-modeladmins``

### Setup:
In your yml config:

    Adrexia\Brand\Brand:
      extensions:
       - SubsiteModelExtension
    Adrexia\Brand\BrandAdmin
      extensions:
       - SubsiteMenuExtension

The brand extension is supplied by the subsite modeladmin module. The BrandAdmin extension is straight from the subsites module, and enables the menu item in the CMS menu.

## Screenshots
![](images/screenshots/colours.png)

![](images/screenshots/fonts.png)

![](images/screenshots/images.png)
