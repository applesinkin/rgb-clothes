<?php
/**
 * Template part for displaying single post content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rgb_clothes
 */

$terms = get_the_terms( get_the_ID(), 'clothes-type' );

$size = rgb_clothes_get_acf_meta('rgb_clothes_size', get_the_ID());
$color = rgb_clothes_get_acf_meta('rgb_clothes_color', get_the_ID());
$sex = rgb_clothes_get_acf_meta('rgb_clothes_sex', get_the_ID());
?>

<article id="post-<?php the_ID(); ?>" class="pt-5 pb-5">

    <div class="container">

        <div>
            <?php the_title('<h1 class="h3 rgb-product rgb-product--single mb-3">', '</h1>'); ?>

            <?php if ( $terms && sizeof($terms) ): ?>
                <ul class="list-group list-group-horizontal pb-4">
                    <?php foreach ($terms as $term): ?>
                        <li class="list-group-item pt-1 pb-1 pl-2 pr-2">
                            <a href="<?php echo get_term_link($term) ?>"><?php echo $term->name; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="row">

            <div class="col-xs-12 col-md-5">
                <?php the_post_thumbnail('rgb-clothes-product-single'); ?>
            </div>

            <div class="col-xs-12 col-md-7 pt-4 pt-md-0">
                <?php the_content(); ?>

                <dl class="row">

                    <?php if ($size): ?>
                        <dt class="col-sm-2">
                            <h6><strong><?php _e('Size:', 'rgb-clothes'); ?></strong></h6>
                        </dt>
                        <dd class="col-sm-10">
                            <p class="h6"><?php echo $size; ?></p>
                        </dd>
                    <?php endif; ?>

                    <?php if ($color): ?>
                        <dt class="col-sm-2">
                            <h6><strong><?php _e('Color:', 'rgb-clothes'); ?></strong></h6>
                        </dt>
                        <dd class="col-sm-10">
                            <p class="h6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="bi bi-square-fill" viewBox="0 0 18 18" fill="<?php echo $color; ?>">
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2z"/>
                                </svg>
                            </p>
                        </dd>
                    <?php endif; ?>

                    <?php if ($sex): ?>
                        <dt class="col-sm-2">
                            <h6><strong><?php _e('Sex:', 'rgb-clothes'); ?></strong></h6>
                        </dt>
                        <dd class="col-sm-10">
                            <p class="h6"><?php echo $sex; ?></p>
                        </dd>
                    <?php endif; ?>

                </dl>
            </div>

        </div>

    </div>

</article>
