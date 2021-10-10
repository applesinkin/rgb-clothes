<?php

function rgb_clothes_load_template($template, $is_require = false) {
    if ( $overridden_template = locate_template('rgb-clothes/' . $template) ) {
        load_template( $overridden_template, $is_require );
    } else {
        load_template( RGB_CLOTHES_PLUGIN_DIR . 'templates/' . $template, $is_require );
    }
}


function rgb_clothes_get_acf_meta ($selector, $post_id) {
    if ( !function_exists('get_field') ) {
        return null;
    }
    return get_field($selector, $post_id);
}


function rgb_clothes_update_acf_meta ($selector, $value, $post_id) {
    if ( !function_exists('update_field') ) {
        return null;
    }
    return update_field($selector, $value, $post_id);
}