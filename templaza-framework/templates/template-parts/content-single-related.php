<?php
defined('ABSPATH') or exit();
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $options = array();
}else{
    $options            = Functions::get_theme_options();
}
$related_col      = isset($options['blog-related-column'])?$options['blog-related-column']:3;
$related_limit      = isset($options['blog-related-limit'])?$options['blog-related-limit']:3;
$show_author        = isset($options['blog-page-author'])?filter_var($options['blog-page-author'], FILTER_VALIDATE_BOOLEAN):true;
$show_date          = isset($options['blog-page-date'])?filter_var($options['blog-page-date'], FILTER_VALIDATE_BOOLEAN):true;
global $post;
$post_cats = wp_get_post_categories($post->ID);
if ($post_cats) {
    $post_cat_ids = array();
    foreach($post_cats as $post_cat_item) $post_cat_ids[] = $post_cat_item;
    $templaza_args=array(
        'category__in'          => $post_cat_ids,
        'post__not_in'          => array($post->ID),
        'posts_per_page'        => $related_limit
    );
    $templaza_query = new wp_query( $templaza_args );
    if($templaza_query->have_posts()){?>

        <div class="templaza-related-posts templaza-archive">
            <h3 class="box-title"><?php echo esc_html__('Related Posts','travelami');?></h3>
            <div class="content-related uk-grid-medium uk-child-width-1-<?php echo esc_attr($related_col);?>@m uk-child-width-1-2@s" data-uk-grid>
                <?php
                while( $templaza_query->have_posts() ) {
                    $templaza_query->the_post();
                    $format = get_post_format($templaza_query->post->ID) ? : 'standard';
                    ?>
                    <div class="templaza-blog-item uk-position-relative">
                        <?php
                        if(has_post_thumbnail($templaza_query->post->ID)){
                        ?>
                        <div class="templaza-blog-item-wrap templaza-archive-item uk-margin-bottom">
                            <div class="uk-cover-container">
                                <canvas width="400" height="300"></canvas>
                                <a href="<?php the_permalink();?>">
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url($templaza_query->post->ID));?>" alt="" data-uk-cover>
                                </a>
                            </div>
                        </div>
                            <?php
                        }
                            ?>
                        <div class="templaza-blog-item-content">
                        <?php if($show_date || $show_author){ ?>
                            <div class="templaza-post-meta templaza-blog-item-info-top">
                                <?php if($show_date){ ?>
                                <span>
                                    <?php echo esc_attr(get_the_date()); ?>
                                </span>
                                <?php } ?>
                                <?php if($show_author){ ?>
                                <span class="author">
                                        <?php echo esc_html__('By: ', 'travelami') .' '. get_the_author_posts_link();?>
                                </span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                            <h4>
                                <a href="<?php the_permalink();?>">
                                    <?php the_title();?>
                                </a>
                            </h4>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
        <?php
    }
}