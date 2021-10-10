<?php

/**
 * Set new image sizes
 *
 * @package rgb_clothes
 */


class RGB_Clothes_Image_Sizes {

	public function add_new_image_sizes() {
        add_image_size( 'rgb-clothes-product-single', 500, 500, true );
        add_image_size( 'rgb-clothes-product-archive', 400, 300, true );
        add_image_size( 'rgb-clothes-taxonomy-top', 1600, 400, true );
	}
	
}
