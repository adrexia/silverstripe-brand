# Silverstripe Brand module

A module to assist with a website's basic branding. Allows setting of brand colours and fonts from within a Silverstripe Admin.


## Requirements

SilverStripe 3.3 or higher

## Installation

``composer require adrexia/brand``

## Setup
Include the brand template in the head of you page template:  
``<% include Brand %>``

By default this includes the fonts and the font-color. The Palette colours are for use on other page types, or for custom theming. For example, they can be used to add a restricted colourpalette to a page (with the help of the Color Palette module):


	$brand = Brand::get()->First();

	if($brand) {
		$fields->insertAfter(
			ColorPaletteField::create(
				"Colour", "Colour", $brand->getPalette()
			), "Intro"
		);
	}

There is an extension 'BrandPageExtension' included for this purpose which adds a
brand colour, a contrast colour, and an image. To enable it, add this to your _config.yml file:

	Page:
	  extensions:
	   - BrandExtension


The other variables provided can be called in a template with:  
``$Brand.Logo``   
``$Brand.BodyBackgroundColour``

## Screenshots
![](images/screenshots/colours.png)

![](images/screenshots/fonts.png)

![](images/screenshots/images.png)
