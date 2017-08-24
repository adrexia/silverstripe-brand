<?php

namespace Adrexia\Brand;

use SilverStripe\ORM\DataExtension;


/**
 * Access branding from pages
 *
 * @package brand
 */

class BrandSiteTreeExtension extends DataExtension {
    public function getBrand() {
        return Brand::get()->First();
    }
}
