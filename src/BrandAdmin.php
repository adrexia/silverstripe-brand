<?php

namespace Adrexia\Brand;

use LittleGiant\SingleObjectAdmin\SingleObjectAdmin;


/**
* Management interface for Brand
*
* @package brand
*/

class BrandAdmin extends SingleObjectAdmin {

    private static $url_segment = 'brand';
    private static $tree_class = Brand::class;
    private static $menu_title = 'Brand';
    private static $menu_icon = "vendor/adrexia/brand/images/palette.svg";

}
