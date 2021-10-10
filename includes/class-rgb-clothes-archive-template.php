<?php

/**
 * Set single template
 */


class RGB_Clothes_Archive_Template {

	public function set_archive_template($template, $type, $templates) {

        global $post;

        if (is_tax() && get_post_type($post) == 'clothes') {

            if ( file_exists( get_stylesheet_directory() . "/rgb-clothes/taxonomy-clothes.php" ) ) {
                return get_stylesheet_directory() . "/rgb-clothes/taxonomy-clothes.php";
            }

            return RGB_CLOTHES_PLUGIN_DIR . 'templates/taxonomy-clothes.php';
        }

        if (is_archive() && get_post_type($post) == 'clothes') {
            if ( file_exists( get_stylesheet_directory() . "/rgb-clothes/archive-clothes.php" ) ) {
                return get_stylesheet_directory() . "/rgb-clothes/archive-clothes.php";
            }

            return RGB_CLOTHES_PLUGIN_DIR . 'templates/archive-clothes.php';
        }

        return $template;

	}
	
}
