<?php

class Brand extends DataObject implements PermissionProvider {
	private static $db = array(
		"PaletteColour1" => 'Varchar(255)',
		"PaletteColour2" => 'Varchar(255)',
		"PaletteColour3" => 'Varchar(255)',
		"PaletteColour4" => 'Varchar(255)',
		"PaletteColour5" => 'Varchar(255)',
		"PaletteColour6" => 'Varchar(255)',

		"BodyBackgroundColour" => 'Varchar(255)',
		"BodyFontColour" => 'Varchar(255)',

		"FontImportURLS" => "Text",
		"HeadingFont" => "Varchar(255)",
		"BodyFont" => "Varchar(255)"
	);

	private static $has_one = array(
		'Logo' => 'Image',
		'Favicon' => 'Image'
	);


	public function getCMSFields() {
		$fields = parent::getCMSFields();


		$fields->addFieldsToTab('Root.Colours',
			LiteralField::create('BodyColours', '<p class="message">Please choose a default body background colour and a contrasting font colour</p>')
		);

		$fields->addFieldsToTab('Root.Colours',
			ColorField::create('BodyBackgroundColour')
		);
		$fields->addFieldsToTab('Root.Colours',
			ColorField::create('BodyFontColour')
		);

		$fields->addFieldsToTab('Root.Colours',
			LiteralField::create('PaletteColours', '<p class="message">The palette defined here will be used to provide colour options on pages and objects throughout your site</p>')
		);
		$fields->addFieldsToTab('Root.Colours',
			ColorField::create('PaletteColour1')
		);
		$fields->addFieldsToTab('Root.Colours',
			ColorField::create('PaletteColour2')
		);
		$fields->addFieldsToTab('Root.Colours',
			ColorField::create('PaletteColour3')
		);
		$fields->addFieldsToTab('Root.Colours',
			ColorField::create('PaletteColour4')
		);
		$fields->addFieldsToTab('Root.Colours',
			ColorField::create('PaletteColour5')
		);
		$fields->addFieldsToTab('Root.Colours',
			ColorField::create('PaletteColour6')
		);

		$fields->addFieldsToTab('Root.Fonts', $fontURLS = TextareaField::create('FontImportURLS'));
		$fontURLS->setDescription('One font import statement per line. Example from google fonts: @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700,300,600|Pacifico); <br /> Find more fonts here: https://www.google.com/fonts');

		$fields->addFieldsToTab('Root.Fonts', $headingFont = TextField::create('HeadingFont'));
		$headingFont->setDescription('e.g. Open Sans. Note: should be in the same case as the import url above');

		$fields->addFieldsToTab('Root.Fonts', $headingFont = TextField::create('BodyFont'));
		$headingFont->setDescription('e.g. Open Sans. Note: should be in the same case as the import url above');

		$fields->addFieldToTab('Root.Logos', $logoField = new UploadField('Logo', 'Logo'));
		$logoField->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif', 'svg'));
		$logoField->setConfig('allowedMaxFileNumber', 1);
		$logoField->setFolderName('Uploads/brand');

		$fields->addFieldToTab('Root.Logos', $favField = new UploadField('Favicon', 'Favicon'));
		$favField->getValidator()->setAllowedExtensions(array('ico', 'png'));
		$favField->setConfig('allowedMaxFileNumber', 1);
		$favField->setFolderName('Uploads/brand');

		$fields->removeByName('Main');

		return $fields;
	}

	public function getPalette() {
		return array(
			"PaletteColour1" => $this->PaletteColour1,
			"PaletteColour2" => $this->PaletteColour2,
			"PaletteColour3" => $this->PaletteColour3,
			"PaletteColour4" => $this->PaletteColour4,
			"PaletteColour5" => $this->PaletteColour5,
			"PaletteColour6" => $this->PaletteColour6,
		);
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
		if(BrandObject::get()) {
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
