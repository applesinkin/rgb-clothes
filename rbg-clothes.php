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
require_once RGB_CLOTHES_PLUGIN_DIR . 'includes/class-tgm-plugin-activation.php';


/**
 * Plugin functions
 */
require RGB_CLOTHES_PLUGIN_DIR . 'includes/plugin-functions.php';


/**
 * Plugin tags
 */
require RGB_CLOTHES_PLUGIN_DIR . 'includes/plugin-tags.php';


//function rgb_closest_form_shortcode() {
//    ob_start();
//    rgb_clothes_load_template( 'form-create-product.php' );
//    return ob_get_clean();
//}
//add_shortcode( 'rgb_closest_form', 'rgb_closest_form_shortcode' );



require plugin_dir_path( __FILE__ ) . 'includes/class-rgb-clothes.php';

function run_plugin_name() {
    $plugin = new RGB_Clothes();
    $plugin->run();
}

run_plugin_name();
