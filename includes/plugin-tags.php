<?php
/**
 * Plugin tags
 *
 * @package rgb_clothes
 */


/* custom pagination */

if ( !file_exists('rgb_clothes_paginate_links') ) {

    function rgb_clothes_paginate_links()
    {
        $total = $GLOBALS["wp_query"]->max_num_pages;

        $return = '';

        if ($total > 1) {
            $links = paginate_links(array(
                'type' => 'array',
                'prev_next' => True,
                'prev_text' => __('Previous'),
                'next_text' => __('Next'),
            ));

            $return .= '<ul class="pagination justify-content-center">';
            foreach ($links as $key => $link) {

                $pattern = array(
                    '/page-numbers/',
                );
                $replacement = array(
                    'page-link',
                );
                $link_replaced = preg_replace($pattern, $replacement, $link);

                $item_class = array('page-item');
                if (preg_match('/current/', $link)) {
                    $item_class[] = 'active';
                }

                $return .= '<li class="' . implode(' ', $item_class) . '">' . $link_replaced . '</li>';
            }
            $return .= '</ul>';
        }

        echo $return;
    }

}