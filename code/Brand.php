<?php

class Brand extends DataObject implements PermissionProvider {
	private static $db = array(
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
		"MainHeadingFontSize" => "Int"
	);

	private static $has_one = array(
		'Logo' => 'Image',
		'Favicon' => 'Image'
	);

	private static $defaults = array(
		"ContrastColour1" => '#333333',
		"ContrastColour2" => '#29c407',
		"ContrastColour3" => '#e7e7e7',
		"ContrastColour4" => '#ffffff',

		"PaletteColour1" => '#600083',
		"PaletteColour2" => '#ffffff',
		"PaletteColour3" => '#29c407',
		"PaletteColour4" => '#decafe',
		"PaletteColour5" => '#e00a95',
		"PaletteColour6" => '#077fc4'
	);

	public function getCMSFields() {
		$this->beforeUpdateCMSFields(function ($fields) {
			$fields->addFieldsToTab('Root.Palette',
				LiteralField::create('ContrastColours', '<p class="message">Constrast colours are usually grey scale, and include both light and dark variations</p>')
			);

			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('ContrastColour1', '1st Contrast Colour')
			);
			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('ContrastColour2', '2nd Contrast Colour')
			);
			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('ContrastColour3', '3rd Contrast Colour')
			);
			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('ContrastColour4', '4th Contrast Colour')
			);

			$fields->addFieldsToTab('Root.Palette',
				LiteralField::create('PaletteColours', '<p class="message">The palette defined here will be used to provide colour options on pages and objects throughout your site</p>')
			);

			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('PaletteColour1', '1st Brand Colour')
			);
			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('PaletteColour2', '2nd Brand Colour')
			);
			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('PaletteColour3', '3rd Brand Colour')
			);
			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('PaletteColour4', '4th Brand Colour')
			);
			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('PaletteColour5', '5th Brand Colour')
			);
			$fields->addFieldsToTab('Root.Palette',
				ColorField::create('PaletteColour6', '6th Brand Colour')
			);



			$fields->addFieldsToTab('Root.Colours',
				LiteralField::create('BodyLit', '<h3>Body</h3>')
			);

			$fields->addFieldsToTab('Root.Colours',
				ColorPaletteField::create('BodyBackgroundColour', 'Body background colour', $this->getFullPalette())
			);
			$fields->addFieldsToTab('Root.Colours',
				ColorPaletteField::create('BodyFontColour', 'Body font colour', $this->getFullPalette())
			);
			$fields->addFieldsToTab('Root.Colours',
				ColorPaletteField::create('BodyLinkColour', 'Link colour', $this->getFullPalette())
			);
			$fields->addFieldsToTab('Root.Colours',
				ColorPaletteField::create('BodyLinkHoverColour', 'Link hover colour', $this->getFullPalette())
			);

			$fields->addFieldsToTab('Root.Colours',
				LiteralField::create('MenuLit', '<h3>Menu</h3>')
			);

			$fields->addFieldsToTab('Root.Colours',
				ColorPaletteField::create('MenuBackgroundColour', 'Menu background colour', $this->getFullPalette())
			);
			$fields->addFieldsToTab('Root.Colours',
				ColorPaletteField::create('MenuFontColour', 'Menu font colour', $this->getFullPalette())
			);

			$fields->addFieldsToTab('Root.Fonts', $fontURLS = TextareaField::create('FontImportURLS'));
			$fontURLS->setDescription('One font import statement per line. Example from google fonts: @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700,300,600|Pacifico); <br /> Find more fonts here: https://www.google.com/fonts');

			$fields->addFieldsToTab('Root.Fonts', $headingFont = TextField::create('HeadingFont'));
			$headingFont->setDescription('e.g. Open Sans. Note: should be in the same case as the import url above');

			$fields->addFieldsToTab('Root.Fonts', $headingFont = TextField::create('BodyFont'));
			$headingFont->setDescription('e.g. Open Sans. Note: should be in the same case as the import url above');

			$fields->addFieldsToTab('Root.Fonts', $baseFont = TextField::create('BaseFontSize'));
			$baseFont->setDescription('Base Body Font size (in pixels)');

			$fields->addFieldsToTab('Root.Fonts', $h1Font = TextField::create('MainHeadingFontSize'));
			$h1Font->setDescription('Size of the page heading text (in pixels)');

			$fields->addFieldToTab('Root.Logos', $logoField = new UploadField('Logo', 'Logo'));
			$logoField->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif', 'svg'));
			$logoField->setConfig('allowedMaxFileNumber', 1);
			$logoField->setFolderName('Uploads/brand');

			$fields->addFieldToTab('Root.Logos', $favField = new UploadField('Favicon', 'Favicon'));
			$favField->getValidator()->setAllowedExtensions(array('ico', 'png'));
			$favField->setConfig('allowedMaxFileNumber', 1);
			$favField->setFolderName('Uploads/brand');

			$fields->removeByName('Main');
		});
		return parent::getCMSFields();
	}

	/**
	 * Returns the CMS defined contrasting colours palette.
	 *
	 * @return Array
	 */
	public function getContrastColours() {
		return array(
			"ContrastColour1" => $this->ContrastColour1,
			"ContrastColour2" => $this->ContrastColour2,
			"ContrastColour3" => $this->ContrastColour3,
			"ContrastColour4" => $this->ContrastColour4
		);
	}

	/**
	 * Returns the CMS defined Brand colours palette.
	 *
	 * @return Array
	 */
	public function getPaletteColours() {
		return array(
			'PaletteColour1' => $this->PaletteColour1,
			'PaletteColour2' => $this->PaletteColour2,
			'PaletteColour3' => $this->PaletteColour3,
			'PaletteColour4' => $this->PaletteColour4,
			'PaletteColour5' => $this->PaletteColour5,
			'PaletteColour6' => $this->PaletteColour6,
		);
	}

	/**
	 * Returns the CMS defined colour palette.
	 *
	 * @return Array
	 */
	public function getFullPalette() {
		return array(
			"ContrastColour1" => $this->ContrastColour1,
			"ContrastColour2" => $this->ContrastColour2,
			"ContrastColour3" => $this->ContrastColour3,
			"ContrastColour4" => $this->ContrastColour4,
			'PaletteColour1' => $this->PaletteColour1,
			'PaletteColour2' => $this->PaletteColour2,
			'PaletteColour3' => $this->PaletteColour3,
			'PaletteColour4' => $this->PaletteColour4,
			'PaletteColour5' => $this->PaletteColour5,
			'PaletteColour6' => $this->PaletteColour6
		);
	}

	/**
	 * Takes a Brand DB field name and returns the accociated Hex colour
	 *
	 * @param String | DB field name (eg 'PaletteColour1')
	 * @return String | Hex colour
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
	 * @param $color Hex String
	 * @return Array
	 */
	public function getRGBArray($color) {

		$hex = ltrim($color, '#');
		$result = array();

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
	 * @param $color Hex String
	 * @return String RGB value (eg "26,35,255")
	 */
	public function getColorAsRGB($color) {
		$result = $this->getRGBArray($color);
		return implode($result, ',');
	}

	/**
	 * Returns a brightness calculation (lower numbers are darker, higher is lighter)
	 * @param $color Hex String
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
	 * @param $color Hex String
	 * @return String
	 */
	public function getContrast($color) {
		$brightness = $this->getBrightnessCalc($color);

		if ($brightness > 130) {
			return 'light';
		}
		return 'dark';
	}


	public function canView($member = null) {
		return Permission::check('BRAND_VIEW');
	}

	public function canEdit($member = null) {
		return Permission::check('BRAND_EDIT');
	}

	public function canDelete($member = null) {
		return Permission::check('BRAND_DELETE');
	}

	public function canCreate($member = null) {
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
