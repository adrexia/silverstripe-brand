<?php

namespace Adrexia\Brand;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use Heyday\ColorPalette\Fields\ColorPaletteField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\PermissionProvider;
use Rhym\ColorField\ColorField;


class Brand extends DataObject implements PermissionProvider {
    use Configurable;

    private static $table_name = 'Brand';

    private static $db = [
        "ContrastColour1" => 'Varchar(255)',
        "ContrastColour2" => 'Varchar(255)',
        "ContrastColour3" => 'Varchar(255)',
        "ContrastColour4" => 'Varchar(255)',

        "PaletteColour1" => 'Varchar(255)',
        "PaletteColour2" => 'Varchar(255)',
        "PaletteColour3" => 'Varchar(255)',
        "PaletteColour4" => 'Varchar(255)',
        "PaletteColour5" => 'Varchar(255)',
        "PaletteColour6" => 'Varchar(255)',

        "BodyBackgroundColour" => 'Varchar(255)',
        "BodyFontColour" => 'Varchar(255)',
        "BodyLinkColour" => 'Varchar(255)',
        "BodyLinkHoverColour" => 'Varchar(255)',

        "MenuBackgroundColour" => 'Varchar(255)',
        "MenuFontColour" => 'Varchar(255)',

        "FontImportURLS" => "Text",
        "HeadingFont" => "Varchar(255)",
        "BodyFont" => "Varchar(255)",
        "BaseFontSize" => "Int",
        "MainHeadingFontSize" => "Int",
        "FaviconTileColor" => 'Varchar(255)',
    ];

    private static $has_one = [
        'Logo' => File::class,
        'FaviconICO' => Image::class,
        'FaviconPNG' => Image::class,
    ];

    private static $defaults = [
        "ContrastColour1" => '#111111',
        "ContrastColour2" => '#333333',
        "ContrastColour3" => '#e7e7e7',
        "ContrastColour4" => '#ffffff',

        "PaletteColour1" => '#600083',
        "PaletteColour2" => '#ffffff',
        "PaletteColour3" => '#29c407',
        "PaletteColour4" => '#decafe',
        "PaletteColour5" => '#e00a95',
        "PaletteColour6" => '#077fc4'
    ];

    private static $edit_constrast_options = true;
    private static $edit_palette_options = true;
    private static $edit_bodycolors = true;
    private static $edit_menucolors = true;
    private static $edit_fonts = true;
    private static $edit_images = true;

    public function getCMSFields() {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {

            $this->addPalette($fields);
            $this->addContrast($fields);

            $fields->addFieldToTab('Root.Colours',
                LiteralField::create('ColoursLit', '<p class="message">Globally applied colour schemes</p>')
            );
            $this->addBodyColours($fields);
            $this->addMenuColours($fields);
            $this->addFonts($fields);
            $this->addImages($fields);

            $fields->removeByName('Main');
        });
        return parent::getCMSFields();
    }

    /**
     * @param FieldList $fields
     */
    public function addContrast(FieldList $fields) {
        if(!self::config()->edit_constrast_options) {
            return;
        }
        $fields->addFieldsToTab('Root.Palette', [
            LiteralField::create('ContrastColours', '<p class="message">Constrast colours are usually grey scale, and include both light and dark variations</p>'),
            ColorField::create('ContrastColour1', '1st Contrast Colour'),
            ColorField::create('ContrastColour2', '2nd Contrast Colour'),
            ColorField::create('ContrastColour3', '3rd Contrast Colour'),
            ColorField::create('ContrastColour4', '4th Contrast Colour')
        ]);
    }

    /**
     * @param FieldList $fields
     */
    public function addPalette(FieldList $fields) {
        if(!self::config()->edit_palette_options) {
            return;
        }

        $fields->addFieldsToTab('Root.Palette', [
            LiteralField::create('PaletteColours', '<p class="message">The palette defined here will be used to provide colour options on pages and objects throughout your site</p>'),
            ColorField::create('PaletteColour1', '1st Brand Colour'),
            ColorField::create('PaletteColour2', '2nd Brand Colour'),
            ColorField::create('PaletteColour3', '3rd Brand Colour'),
            ColorField::create('PaletteColour4', '4th Brand Colour'),
            ColorField::create('PaletteColour5', '5th Brand Colour'),
            ColorField::create('PaletteColour6', '6th Brand Colour')
        ]);
    }

    /**
     * @param FieldList $fields
     */
    public function addImages(FieldList $fields) {
        if(!self::config()->edit_images) {
            return;
        }
        $fields->addFieldsToTab('Root.Images', [
            $logoField = new UploadField('Logo', 'Logo'),
            $favField = new UploadField('FaviconICO', 'Favicon Ico'),
            $favPNGField = new UploadField('FaviconPNG', 'Favicon PNG'),
            ColorPaletteField::create('FaviconTileColor', 'Favicon Tile Color (used by windows)', $this->getFullPalette())
        ]);

        $logoField->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif', 'svg'));
        $logoField->setFolderName('Uploads/brand');

        $favField->getValidator()->setAllowedExtensions(array('ico'));
        $favField->setFolderName('Uploads/brand');

        $favPNGField->getValidator()->setAllowedExtensions(array('png'));
        $favPNGField->setFolderName('Uploads/brand');
        $favPNGField->setRightTitle('Minimum size: 192x192, png');
    }

    /**
     * @param FieldList $fields
     */
    public function addFonts(FieldList $fields) {
        if(!self::config()->edit_fonts) {
            return;
        }

        $fields->addFieldsToTab('Root.Fonts', [
            $fontURLS = TextareaField::create('FontImportURLS'),
            $headingFont = TextField::create('HeadingFont'),
            $bodyFont = TextField::create('BodyFont'),
            $baseFont = TextField::create('BaseFontSize'),
            $h1Font = TextField::create('MainHeadingFontSize')
        ]);

        $fontURLS->setDescription('One font import statement per line. Example from google fonts: @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700,300,600|Pacifico); <br /> Find more fonts here: https://www.google.com/fonts');
        $headingFont->setDescription('e.g. Open Sans. Note: should be in the same case as the import url above');
        $bodyFont->setDescription('e.g. Open Sans. Note: should be in the same case as the import url above');
        $baseFont->setDescription('Base Body Font size (in pixels)');
        $h1Font->setDescription('Size of the page heading text (in pixels)');
    }

    /**
     * @param FieldList $fields
     */
    public function addBodyColours(FieldList $fields) {
        if(!self::config()->edit_bodycolors) {
            return;
        }
        $fields->addFieldsToTab('Root.Colours', [
            LiteralField::create('BodyLit', '<h3>Body</h3>'),
            ColorPaletteField::create('BodyBackgroundColour', 'Body background colour', $this->getFullPalette()),
            ColorPaletteField::create('BodyFontColour', 'Body font colour', $this->getFullPalette()),
            ColorPaletteField::create('BodyLinkColour', 'Link colour', $this->getFullPalette()),
            ColorPaletteField::create('BodyLinkHoverColour', 'Link hover colour', $this->getFullPalette())
        ]);
    }

    /**
     * @param FieldList $fields
     */
    public function addMenuColours(FieldList $fields) {
        if(!self::config()->edit_menucolors) {
            return;
        }
        $fields->addFieldsToTab('Root.Colours', [
            LiteralField::create('MenuLit', '<h3>Menu</h3>'),
            ColorPaletteField::create('MenuBackgroundColour', 'Menu background colour', $this->getFullPalette()),
            ColorPaletteField::create('MenuFontColour', 'Menu font colour', $this->getFullPalette())
        ]);
    }

    /**
     * Publish our dependent objects.
     */
    public function onAfterWrite() {

        if($this->Logo() && $this->Logo()->exists()) {
            $this->Logo()->publishSingle();
        }
        if($this->FaviconICO() && $this->FaviconICO()->exists()) {
            $this->FaviconICO()->publishSingle();
        }
        if($this->FaviconPNG() && $this->FaviconPNG()->exists()) {
            $this->FaviconPNG()->publishSingle();
        }
        parent::onAfterWrite();
    }

    /**
     * Returns the CMS defined contrasting colours palette.
     *
     * @return array
     */
    public function getContrastColours() {
        return [
            "ContrastColour1" => $this->ContrastColour1,
            "ContrastColour2" => $this->ContrastColour2,
            "ContrastColour3" => $this->ContrastColour3,
            "ContrastColour4" => $this->ContrastColour4
        ];
    }

    /**
     * Returns the CMS defined Brand colours palette.
     *
     * @return array
     */
    public function getPaletteColours() {
        return [
            'PaletteColour1' => $this->PaletteColour1,
            'PaletteColour2' => $this->PaletteColour2,
            'PaletteColour3' => $this->PaletteColour3,
            'PaletteColour4' => $this->PaletteColour4,
            'PaletteColour5' => $this->PaletteColour5,
            'PaletteColour6' => $this->PaletteColour6,
        ];
    }

    /**
     * Returns the CMS defined colour palette.
     *
     * @return array
     */
    public function getFullPalette() {
        return [
            'PaletteColour1' => $this->PaletteColour1,
            'PaletteColour2' => $this->PaletteColour2,
            'PaletteColour3' => $this->PaletteColour3,
            'PaletteColour4' => $this->PaletteColour4,
            'PaletteColour5' => $this->PaletteColour5,
            'PaletteColour6' => $this->PaletteColour6,
            "ContrastColour1" => $this->ContrastColour1,
            "ContrastColour2" => $this->ContrastColour2,
            "ContrastColour3" => $this->ContrastColour3,
            "ContrastColour4" => $this->ContrastColour4
        ];
    }

    /**
     * Takes a Brand DB field name and returns the associated Hex colour
     *
     * @param String $index - DB field name (eg 'PaletteColour1')
     * @return String - Hex colour
     */
    public function getHex($index) {
        $palette = $this->getFullPalette();
        if(isset($palette[$index])) {
            return $palette[$index];
        } else {
            return $palette['PaletteColour1'];
        }
    }

    /**
     * Converts a hex value into an array of rgb values (red, green, blue)
     * Can be used to construct an rgba version of the colour
     * And/Or do colour maths.
     *
     * @param $color - Hex String
     * @return array
     */
    public function getRGBArray($color) {

        $hex = ltrim($color, '#');
        $result = [];

        if(strlen($hex) == 3) {
            $result['r'] = hexdec(substr($hex, 0, 1));
            $result['g'] = hexdec(substr($hex, 1, 1));
            $result['b'] = hexdec(substr($hex, 2, 1));
        }
        else if(strlen($hex) == 6) {
            $result['r'] = hexdec(substr($hex, 0, 2));
            $result['g'] = hexdec(substr($hex, 2, 2));
            $result['b'] = hexdec(substr($hex, 4, 2));
        }

        return $result;
    }

    /**
     * Converts a hex value into an rgb value. Can be used in the template
     * to crwate rgba colours.
     * @param  String $color - Hex String
     * @return String RGB value (eg "26,35,255")
     */
    public function getColorAsRGB($color) {
        $result = $this->getRGBArray($color);
        return implode($result, ',');
    }

    /**
     * Returns a brightness calculation (lower numbers are darker, higher is lighter)
     * @param String $color - Hex String
     * @return Int
     */
    public function getBrightnessCalc($color) {
        $rgb = $this->getRGBArray($color);
        return (($rgb['r'] * 299) + ($rgb['g'] * 587) + ($rgb['b'] * 114)) / 1000;
    }

    /**
     * Returns a string of the current contrast of a colour (light or dark)
     * Useful for calculating whether a text colour must be dark or light, when
     * supplied with a background colour. If this outputs light, then we know the
     * text must be a dark shade in order to get satisfactory contrast
     *
     * @param String $color - Hex String
     * @return String
     */
    public function getContrast($color) {
        $brightness = $this->getBrightnessCalc($color);

        if ($brightness > 130) {
            return 'light';
        }
        return 'dark';
    }

    public function canView($member = NULL, $context = []) {
        return Permission::check('BRAND_VIEW');
    }

    public function canEdit($member = NULL, $context = []) {
        return Permission::check('BRAND_EDIT');
    }

    public function canDelete($member = NULL, $context = []) {
        return Permission::check('BRAND_DELETE');
    }

    /**
     * Limit to one brand per (sub)site
     * @param null $member
     * @param array $context
     * @return bool|int
     */
    public function canCreate($member = NULL, $context = []) {
        if(Brand::get()) {
            return false;
        }
        return Permission::check('BRAND_CREATE');
    }


    /**
     * Get an array of {@link Permission} definitions that this object supports
     *
     * @return array
     */
    public function providePermissions() {
        return array(
            'BRAND_VIEW' => array(
                'name' => 'View brand',
                'category' => 'Module',
            ),
            'BRAND_EDIT' => array(
                'name' => 'Edit brand',
                'category' => 'Module',
            ),
            'BRAND_DELETE' => array(
                'name' => 'Delete brand',
                'category' => 'Module',
            ),
            'BRAND_CREATE' => array(
                'name' => 'Create brand',
                'category' => 'Module'
            )
        );
    }

}
