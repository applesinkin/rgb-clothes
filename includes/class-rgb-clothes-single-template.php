<?php

/**
 * Set single template
 */


class RGB_Clothes_Single_Template {

	public function set_single_template($template, $type, $templates) {

        foreach( $templates as $tlp ) {
            if ( file_exists( get_stylesheet_directory() . "/rgb-clothes/" . $tlp ) ) {
                $template = get_stylesheet_directory() . "/rgb-clothes/" . $tlp;
            }
            if ( file_exists( RGB_CLOTHES_PLUGIN_DIR . 'templates/' . $tlp ) ) {
                $template = RGB_CLOTHES_PLUGIN_DIR . 'templates/' . $tlp;
            }
        }

        return $template;
	}
	
}
