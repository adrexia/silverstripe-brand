<?php
/**
 * Access branding from pages
 *
 * @package brand
 */

class BrandSiteTreeExtension extends DataExtension {

	public function getBrand(){
		return Brand::get()->First();
	}
}
