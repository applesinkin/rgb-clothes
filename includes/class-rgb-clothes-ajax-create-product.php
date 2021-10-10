<?php

/**
 * Set single template
 */


class RGB_Clothes_Ajax_Create_Product {

	public function create_product() {

        wp_send_json_success('test123');

        // check user roles
        $user = wp_get_current_user();
        $allowed_roles = array('editor', 'administrator');
        if ( !array_intersect($allowed_roles, $user->roles) ) {
            wp_send_json_error( array('message' => 'The action is not permitted') );
        }

        // check nonce
        if (
            !isset( $_POST['rgb_clothes_create_product_nonce'] ) ||
            !wp_verify_nonce( $_POST['rgb_clothes_create_product_nonce'], 'rgb_clothes_create_product' )
        ) {
            wp_send_json_error( array('message' => 'The action is not permitted') );
        }

        $post_data = array(
            'post_title' => sanitize_text_field( $_POST['title'] ),
            'post_content' => $_POST['description'],
            'post_status' => 'publish',
            'post_type' => 'clothes',
            'post_author' => get_current_user_id(),
        );

        $post_id = wp_insert_post( $post_data );

        if ( !isset($post_id) ) {
            wp_send_json_error( array('message' => "The post hasn't been created") );
        }

        // set post terms
        if ( isset($_POST['types']) ) {
            wp_set_object_terms( $post_id, explode(',', $_POST['types']), 'clothes-type' );
        }

        // set ACF meta values
        if ( isset($_POST['size']) ) {
            rgb_clothes_update_acf_meta('field_rgb_clothes_size', $_POST['size'], $post_id);
        }
        if ( isset($_POST['color']) ) {
            rgb_clothes_update_acf_meta('field_rgb_clothes_color', $_POST['color'], $post_id);
        }
        if ( isset($_POST['sex']) ) {
            rgb_clothes_update_acf_meta('field_rgb_clothes_sex', $_POST['sex'], $post_id);
        }

        // set thumbnails
        if ( isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name'] != "" ) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $attachment_id = media_handle_upload('thumbnail', $post_id);

            if ($attachment_id) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }

        wp_send_json_success($post_id);

	}
	
}
