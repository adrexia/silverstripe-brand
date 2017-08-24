<?php

namespace Adrexia\Brand;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use Heyday\ColorPalette\Fields\ColorPaletteField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\DataExtension;


/**
 * Add branding to pages (or dataobjects with a "Content" field)
 *
 * @package brand
 */

class BrandDataObjectExtension extends DataExtension {

    private static $db = array(
        'Colour' => 'Varchar(255)',
        'ContrastColour' => 'Varchar(255)',
    );

    private static $has_one = array(
        'SplashImage' => Image::class
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {

        $brand = $this->owner->getBrand();

        if($brand) {
            $fields->insertBefore(
                ColorPaletteField::create(
                    "Colour", "Colour", $brand->getPaletteColours()
                ), "Content"
            );

            $fields->insertBefore(
                $contrast = ColorPaletteField::create(
                    "ContrastColour", "Contrast Colour", $brand->getContrastColours()
                ), "Content"
            );

            $contrast->setDescription("Used for any text on 'Colour'");
        }

        $fields->insertAfter($image = UploadField::create('SplashImage', 'Splash Image'),'ContrastColour');
        $image->setFolderName('Uploads/Splash-Images');
    }
}
