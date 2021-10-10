<?php
/**
 * Add "Clothes" post type
 *
 * @package rgb_clothes
 */

/**
 * Register post type
 */
function _action_rgb_clothes_post_type_init() {

	register_post_type('clothes', array(
		'labels'             => array(
			'name'               => __('Clothes', 'rgb-clothes'),
			'singular_name'      => __('Clothes item', 'rgb-clothes'),
			'parent_item_colon'  => '',
			'menu_name'          => __('Clothes', 'rgb-clothes')
        ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor','thumbnail')
	) );
}
add_action('init', '_action_rgb_clothes_post_type_init');



/**
 * Register post type "clothes" meta fields
 */

function _action_rgb_clothes_add_post_clothes_meta() {

    if( function_exists('acf_add_local_field_group') ) {

        acf_add_local_field_group(array(
            'key' => 'rgb_type_clothes_options',
            'title' => __('Clothes Options', 'rgb-clothes'),
            'fields' => array(
                array(
                    'label' => __('Size', 'rgb-clothes'),
                    'name' => 'rgb_clothes_size',
                    'type' => 'number',
                    'key' => 'field_rgb_clothes_size',
                    'min' => 0,
                ),
                array(
                    'label' => __('Color', 'rgb-clothes'),
                    'name' => 'rgb_clothes_color',
                    'type' => 'color_picker',
                    'key' => 'field_rgb_clothes_color',
                ),
                array(
                    'label' => __('Sex', 'rgb-clothes'),
                    'name' => 'rgb_clothes_sex',
                    'type' => 'radio',
                    'key' => 'field_rgb_clothes_sex',
                    'layout' => 'horizontal',
                    'return_format' => 'label',
                    'choices' => array(
                        'male' => __('Male', 'rgb-clothes'),
                        'female' => __('Female', 'rgb-clothes')
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'value' => 'clothes',
                        'operator' => '==',
                    ),
                ),
            ),
        ));

    }
}

add_action('acf/init', '_action_rgb_clothes_add_post_clothes_meta');