<?php
/**
 * Plugin Name: RGB Clothes
 * Description: Custom clothes catalogue. Use the shortcode [rgb_clothes_create_form] to place the product creating form on pages. To customize templataes, move "template" folder to your theme and rename it to "rgb-clothes".
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


/**
 * Begins execution of the plugin.
 */

require plugin_dir_path( __FILE__ ) . 'includes/class-rgb-clothes.php';

function run_plugin_name() {
    $plugin = new RGB_Clothes();
    $plugin->run();
}

run_plugin_name();
