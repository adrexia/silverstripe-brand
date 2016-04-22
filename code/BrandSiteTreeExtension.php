<?php
/**
 * Override display gridfield to provide more data
 */

class BrandSiteTreeExtension extends DataExtension {

	public function getBrand(){
		return Brand::get()->First();
	}
}
