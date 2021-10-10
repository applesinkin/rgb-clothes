<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package rgb_clothes
 */


class RGB_Clothes_Public {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bootstrap.css', array(), '4.6.0', 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rgb-clothes-scripts.js', array(), $this->version, true );
        wp_localize_script( $this->plugin_name, 'rgbClothesAjax',
            array(
                'url' => admin_url('admin-ajax.php')
            )
        );
	}

}
