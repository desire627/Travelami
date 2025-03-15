<?php
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $travelami_options = array();
}else{
    $travelami_options            = Functions::get_theme_options();
}

$blog_thumbnail_effect = isset($options['blog-single-thumbnail-effect'])?$options['blog-single-thumbnail-effect']:'ripple';
$ripple_cl = $ripple_html =' ';
if($blog_thumbnail_effect =='ripple'){
    $ripple_html = '<div class="templaza-ripple-circles uk-position-center uk-transition-fade">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                    </div>';
    $ripple_cl = ' templaza-thumb-ripple uk-position-relative uk-transition-toggle';
}
?>
<div
    class="our-team-archive ui-post-items uk-child-width-1-3@xl uk-child-width-1-3@l uk-child-width-1-3@m uk-child-width-1-2@s uk-child-width-1-1 uk-grid"
    data-uk-grid="">
    <?php
    if (have_posts()) : while (have_posts()) : the_post();
    ?>
    <article data-cat="sale-manager" >
        <div class="uk-article uk-card uk-transition-toggle templaza-thumbnail-effect uk-card-custom templaza-<?php echo esc_attr($blog_thumbnail_effect . $ripple_cl);?>">
            <a class="uk-position-relative uk-overflow-hidden ui-post-thumbnail uk-display-block uk-card-media-top"
                href="<?php the_permalink() ?>">
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID()));?>"
                     alt="<?php the_title();?>" decoding="async">
                <?php echo wp_kses($ripple_html,'post'); ?>
            </a>
            <div class="ui-post-info-wrap">
                <div class=" uk-card-body uk-padding-remove-left">
                    <h3 class="ui-title uk-margin-remove-top uk-h3 uk-margin-remove-bottom">
                        <a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID()));?>">
                            <?php the_title();?>
                        </a>
                    </h3>
                </div>
            </div>
        </div>
    </article>
    <?php
    endwhile;
    endif;
    ?>
    <div class="templaza-blog-pagenavi uk-margin-top">
        <?php
        do_action('templaza_pagination');
        ?>
    </div>
</div>