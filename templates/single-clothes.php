<?php
/**
 * The template for displaying post type 'clothes' single page
 *
 * @package rgb_clothes
 */

get_header();
?>

    <main id="primary" class="site-main">

        <?php rgb_clothes_load_template('content-clothes-single.php'); ?>

    </main><!-- #main -->

<?php
get_footer();