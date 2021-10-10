<?php
/**
 * Template part for displaying archive post content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rgb_clothes
 */

$size = rgb_clothes_get_acf_meta('rgb_clothes_size', get_the_ID());
$color = rgb_clothes_get_acf_meta('rgb_clothes_color', get_the_ID());
$sex = rgb_clothes_get_acf_meta('rgb_clothes_sex', get_the_ID());
?>

<article id="post-<?php the_ID(); ?>">

    <figure class="product-thumbnail">
        <?php if ( has_post_thumbnail()) { ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('rgb-clothes-product-single'); ?>
            </a>
        <?php } ?>
    </figure>

    <div class="pt-4">

        <?php the_title('<h4 class="h4 rgb-product rgb-product--single mb-3"><a href="' . get_permalink( get_the_ID() ) . '">', '</a></h4>'); ?>

        <dl class="row">

            <?php if ($size): ?>
                <dt class="col-sm-4">
                    <h6><strong><?php _e('Size:', 'rgb-clothes'); ?></strong></h6>
                </dt>
                <dd class="col-sm-8">
                    <p class="h6"><?php echo $size; ?></p>
                </dd>
            <?php endif; ?>

            <?php if ($color): ?>
                <dt class="col-sm-4">
                    <h6><strong><?php _e('Color:', 'rgb-clothes'); ?></strong></h6>
                </dt>
                <dd class="col-sm-8">
                    <p class="h6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="bi bi-square-fill" viewBox="0 0 18 18" fill="<?php echo $color; ?>">
                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2z"/>
                        </svg>
                    </p>
                </dd>
            <?php endif; ?>

            <?php if ($sex): ?>
                <dt class="col-sm-4">
                    <h6><strong><?php _e('Sex:', 'rgb-clothes'); ?></strong></h6>
                </dt>
                <dd class="col-sm-8">
                    <p class="h6"><?php echo $sex; ?></p>
                </dd>
            <?php endif; ?>

        </dl>
    </div>

</article>
