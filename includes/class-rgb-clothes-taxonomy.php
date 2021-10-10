<?php

/**
 * Register all actions and filters for the plugin
 */


class RGB_Clothes_Taxonomy {

    public function register_taxonomy() {

        register_taxonomy( 'clothes-type', ['clothes'], [
            'label' => __('Clothes type', 'rgb-clothes'),
            'labels' => [
                'name' => __('Clothes type', 'rgb-clothes'),
                'singular_name' => __('Clothes type term', 'rgb-clothes'),
            ],
            'description' => '',
            'public' => true,
            'hierarchical' => true,
        ] );

    }

    public function register_taxonomy_meta() {

        if (function_exists('acf_add_local_field_group')) {

            acf_add_local_field_group(array(
                'key' => 'rgb_type_clothes_type_options',
                'title' => __('Clothes Type Options', 'rgb-clothes'),
                'fields' => array(
                    array(
                        'label' => __('Image', 'rgb-clothes'),
                        'name' => 'rgb_clothes_type_image',
                        'type' => 'image',
                        'key' => 'field_rgb_clothes_type_image',
                        'min' => 0,
                    ),
                    array(
                        'label' => __('Description', 'rgb-clothes'),
                        'name' => 'rgb_clothes_type_description',
                        'type' => 'textarea',
                        'key' => 'field_rgb_clothes_type_description',
                        'new_lines' => 'br',
                        'rows' => 4,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'taxonomy',
                            'value' => 'clothes-type',
                            'operator' => '==',
                        ),
                    ),
                ),
            ));

        }
    }

}
