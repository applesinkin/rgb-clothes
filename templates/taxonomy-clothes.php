<?php
/**
 * The template for displaying post type 'clothes' taxonomy page
 *
 * @package rgb_clothes
 */

get_header();

$queried_object = get_queried_object();
$term_id = $queried_object->term_id;

$description = rgb_clothes_get_acf_meta('field_rgb_clothes_type_description', 'term_' . $term_id);
$image = rgb_clothes_get_acf_meta('field_rgb_clothes_type_image', 'term_' . $term_id);
?>

    <main id="primary" class="site-main">

        <div class="container pt-5 pb-5">

            <?php if ( have_posts() ) : ?>
                <header class="page-header mb-5">
                    <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                    <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>

                    <?php if ($description): ?>
                        <p><?php echo $description ?></p>
                    <?php endif; ?>


                    <?php if ($image): ?>
                        <img src="<?php echo $image['sizes']['rgb-clothes-taxonomy-top']; ?>" alt="<?php the_archive_title(); ?>">
                    <?php endif; ?>

                </header>

                <div class="row">
                    <?php while ( have_posts() ): the_post(); ?>

                        <div class="col-sm-3 mb-3">
                            <?php rgb_clothes_load_template('content-clothes.php'); ?>
                        </div>

                    <?php endwhile; ?>
                </div>

                <?php echo rgb_clothes_paginate_links();

            else :

                rgb_clothes_load_template( 'content-none.php', 'none' );

            endif;
            ?>

        </div>

    </main><!-- #main -->

<?php
get_footer();
