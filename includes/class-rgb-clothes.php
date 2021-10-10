<?php

/**
 * The file that defines the core "RGB Clothes" plugin class
 */


class RGB_Clothes {

    protected $loader;
    protected $version;
    protected $plugin_name;


    public function __construct() {
		if ( defined( 'RGB_CLOTHES_VERSION' ) ) {
			$this->version = RGB_CLOTHES_VERSION;
		} else {
			$this->version = '0.0.1';
		}
		$this->plugin_name = 'rgb-clothes';

		$this->load_dependencies();
        $this->register_tgmpa();
        $this->set_new_image_sizes();
        $this->set_post_type();
        $this->set_taxonomy();
        $this->set_shortcodes();
        $this->set_single_template();
        $this->set_archive_template();
        $this->set_archive_posts_count();
        $this->set_ajax_create_product_action();
        $this->define_public_hooks();

    }


	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-tgmpa-register.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-image-sizes.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-post-type.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-taxonomy.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-shortcodes.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-single-template.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-archive-template.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-archive-posts-count.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rgb-clothes-ajax-create-product.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-rgb-clothes-public.php';

		$this->loader = new RGB_Clothes_Loader();

	}


	private function register_tgmpa() {
		$plugin_tgmpa_register = new RGB_Clothes_TGMPA_Register();

		$this->loader->add_action( 'tgmpa_register', $plugin_tgmpa_register, 'register_tgmpa' );
	}


	private function set_new_image_sizes() {
        $plugin_image_sizes = new RGB_Clothes_Image_Sizes();

        $this->loader->add_action( 'init', $plugin_image_sizes, 'add_new_image_sizes' );
    }

	private function set_post_type() {
        $plugin_post_type = new RGB_Clothes_Post_Type();

        $this->loader->add_action( 'init', $plugin_post_type, 'register_post_type' );
        $this->loader->add_action( 'acf/init', $plugin_post_type, 'register_post_meta' );
    }

	private function set_taxonomy() {
        $plugin_taxonomy = new RGB_Clothes_Taxonomy();

        $this->loader->add_action( 'init', $plugin_taxonomy, 'register_taxonomy' );
        $this->loader->add_action( 'acf/init', $plugin_taxonomy, 'register_taxonomy_meta' );
    }


    private function set_shortcodes() {
        $plugin_shortcodes = new RGB_Clothes_Shortcodes();
        $this->loader->add_shortcode( 'rgb_clothes_create_form', $plugin_shortcodes, 'set_shortcode_create_form');
    }


    private function set_single_template() {
        $plugin_single_template = new RGB_Clothes_Single_Template();

        $this->loader->add_filter( 'single_template', $plugin_single_template, 'set_single_template', 10, 3 );
    }


    private function set_archive_template() {
        $plugin_archive_template = new RGB_Clothes_Archive_Template();

        $this->loader->add_filter( 'archive_template', $plugin_archive_template, 'set_archive_template', 10, 3 );
        $this->loader->add_filter( 'taxonomy_template', $plugin_archive_template, 'set_archive_template', 10, 3 );
    }


    private function set_archive_posts_count() {
        $plugin_archive_posts_count = new RGB_Clothes_Archive_Posts_Count();

        $this->loader->add_action( 'pre_get_posts', $plugin_archive_posts_count, 'set_posts_count' );
    }

    private function set_ajax_create_product_action() {
        $plugin_ajax_create_product_action = new RGB_Clothes_Ajax_Create_Product();

        $this->loader->add_action( 'wp_ajax_rgb_clothes_create_item', $plugin_ajax_create_product_action, 'create_product' );
    }


	private function define_public_hooks() {
		$plugin_public = new RGB_Clothes_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}


	public function run() {
		$this->loader->run();
	}


	public function get_plugin_name() {
		return $this->plugin_name;
	}


	public function get_loader() {
		return $this->loader;
	}


	public function get_version() {
		return $this->version;
	}

}
