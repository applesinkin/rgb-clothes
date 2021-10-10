<?php


class RGB_Clothes_TGMPA_Register {

    public function register_tgmpa() {

        $plugins = array(

            array(
                'name'               => 'Advanced Custom Fields',
                'slug'               => 'advanced-custom-fields',
                'required'           => true,
                'version'            => '5.10.2',
            ),
        );

        $config = array(
            'id'           => 'rgb-clothes',
            'default_path' => '',
            'menu'         => 'tgmpa-install-plugins',
            'parent_slug'  => 'plugins.php',
            'capability'   => 'manage_options',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => false,
            'message'      => '',
            'strings'      => array(
                'notice_can_install_required'     => _n_noop(
                    'Plugin "RGB Clothes" requires the following plugin: %1$s.',
                    'Plugin "RGB Clothes" requires the following plugins: %1$s.',
                    'rgb-clothes'
                ),
            ),
        );

        tgmpa( $plugins, $config );
    }

}