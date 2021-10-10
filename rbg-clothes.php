<?php
/**
 * Plugin Name: RGB Clothes
 * Description: Custom clothes catalogue
 * Author:      Applesinkin
 * Version:     0.0.1
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: rgb-clothes
 */


/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}


/**
 * Plugin version
 */
define( 'RGB_CLOTHES_VERSION', '1.0.0' );
define( 'RGB_CLOTHES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RGB_CLOTHES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


/**
 * Register TGMPA
 */
require RGB_CLOTHES_PLUGIN_DIR . 'includes/tgmpa-register.php';


/**
 * Register post types
 */
require RGB_CLOTHES_PLUGIN_DIR . 'includes/post-types/type-clothes.php';


/**
 * Register taxonomies
 */
require RGB_CLOTHES_PLUGIN_DIR . 'includes/post-taxonomies/taxonomy-clothes-type.php';


/**
 * Plugin functions
 */
require RGB_CLOTHES_PLUGIN_DIR . 'includes/plugin-functions.php';


/**
 * Plugin tags
 */
require RGB_CLOTHES_PLUGIN_DIR . 'includes/plugin-tags.php';


/**
 * Add image sizes
 */
function _action_rgb_clothes_add_new_image_sizes() {
    add_image_size( 'rgb-clothes-product-single', 500, 500, true );
    add_image_size( 'rgb-clothes-product-archive', 400, 300, true );
    add_image_size( 'rgb-clothes-taxonomy-top', 1600, 400, true );
}
add_action( 'init', '_action_rgb_clothes_add_new_image_sizes' );


/**
 * Load single template
 */
function _filter_rgb_clothes_load_single_template( $template, $type, $templates ) {

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
add_filter( 'single_template', '_filter_rgb_clothes_load_single_template', 10, 3 );


/**
 * Load archive templates
 */
function _filter_rgb_clothes_load_archive_template( $template, $type, $templates ) {
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
add_filter( 'archive_template', '_filter_rgb_clothes_load_archive_template', 10, 3 );
add_filter( 'taxonomy_template', '_filter_rgb_clothes_load_archive_template', 10, 3 );


function _action_rgb_clothes_change_arhive_posts_count($query) {
    if ( is_post_type_archive('clothes') || is_tax('clothes-type') ) {
        if ( !is_admin() && $query->is_main_query() ) {
            $query->set( 'posts_per_page', '8' );
        }
    }
}
add_action( 'pre_get_posts', '_action_rgb_clothes_change_arhive_posts_count' );


function rgb_closest_form_shortcode() {
    ob_start();
    rgb_clothes_load_template( 'form-create-product.php' );
    return ob_get_clean();
}
add_shortcode( 'rgb_closest_form', 'rgb_closest_form_shortcode' );


function _action_rgb_clothes_scripts() {
    wp_enqueue_script( 'rgb-clothes-scripts', RGB_CLOTHES_PLUGIN_URL . 'public/js/rgb-clothes-scripts.js', array('jquery'), RGB_CLOTHES_VERSION, true );
    wp_localize_script( 'rgb-clothes-scripts', 'rgbClothesAjax',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );
}
add_action( 'wp_enqueue_scripts', '_action_rgb_clothes_scripts' );


function _action_rgb_clothes_styles() {
    wp_enqueue_style( 'rgb-clothes-bootstrap', RGB_CLOTHES_PLUGIN_URL . 'public/css/bootstrap.css', array(), '4.6.0' );
}
add_action( 'wp_enqueue_scripts', '_action_rgb_clothes_styles' );



function _action_rgb_clothes_create_item() {

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
add_action( 'wp_ajax_rgb_clothes_create_item', '_action_rgb_clothes_create_item' );
