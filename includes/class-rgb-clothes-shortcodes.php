<?php

class RGB_Clothes_Shortcodes {

    public function set_shortcode_create_form() {

        ob_start();
        rgb_clothes_load_template( 'form-create-product.php' );
        return ob_get_clean();
    }

}
