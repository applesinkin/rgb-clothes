<?php

/**
 * Set products count
 *
 * @package rgb_clothes
 */


class RGB_Clothes_Archive_Posts_Count {

	public function set_posts_count($query) {

        if ( is_post_type_archive('clothes') || is_tax('clothes-type') ) {
            if ( !is_admin() && $query->is_main_query() ) {
                $query->set( 'posts_per_page', '8' );
            }
        }

	}
	
}
