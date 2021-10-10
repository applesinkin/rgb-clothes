<?php

/**
 * Product create
 *
 * @package rgb_clothes
 */


class RGB_Clothes_Ajax_Create_Product {

	public function create_product() {

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

        $post_title = isset($_POST['title']) ? sanitize_text_field( $_POST['title'] ) : false;
        $post_content = isset($_POST['description']) ? sanitize_textarea_field( $_POST['description'] ) : false;
        $post_types = isset($_POST['types']) ? sanitize_text_field( $_POST['types'] ) : false;
        $post_size = isset($_POST['size']) ? sanitize_text_field( $_POST['size'] ) : false;
        $post_color = isset($_POST['color']) ? sanitize_text_field( $_POST['color'] ) : false;
        $post_sex = isset($_POST['sex']) ? sanitize_text_field( $_POST['sex'] ) : false;

        if (!$post_title) {
            wp_send_json_error( array('message' => "The post title is not defined") );
        }

        $post_data = array(
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_status' => 'publish',
            'post_type' => 'clothes',
            'post_author' => get_current_user_id(),
        );

        $post_id = wp_insert_post( $post_data );

        if ( !isset($post_id) ) {
            wp_send_json_error( array('message' => "The post hasn't been created") );
        }

        // set post terms
        if ($post_types) {
            wp_set_object_terms( $post_id, explode( ',', $post_types ), 'clothes-type' );
        }

        // set ACF meta values
        if ($post_size) {
            rgb_clothes_update_acf_meta('field_rgb_clothes_size', $post_types, $post_id);
        }
        if ($post_color) {
            rgb_clothes_update_acf_meta('field_rgb_clothes_color', $post_color, $post_id);
        }
        if ($post_sex) {
            rgb_clothes_update_acf_meta('field_rgb_clothes_sex', $post_sex, $post_id);
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
