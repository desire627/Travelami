<?php

defined('TEMPLAZA_FRAMEWORK');

use TemPlazaFramework\CSS;
use TemPlazaFramework\Functions;
use TemPlazaFramework\Templates;

$travelami_id             = isset($atts['id'])?$atts['id']:time();
$travelami_custom_class   = isset($atts['custom-container-class'])?' '.$atts['custom-container-class']:'';
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $travelami_options = array();
}else{
    $travelami_options            = Functions::get_theme_options();
}
$travelami_post_type       = get_post_type(get_the_ID());
$prefix                 = 'blog-single';

$travelami_show_thumbnail         = isset($travelami_options[$prefix.'-thumbnail'])?filter_var($travelami_options[$prefix.'-thumbnail'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_tag               = isset($travelami_options[$prefix.'-tag'])?filter_var($travelami_options[$prefix.'-tag'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_meta              = isset($travelami_options[$prefix.'-meta'])?filter_var($travelami_options[$prefix.'-meta'], FILTER_VALIDATE_BOOLEAN):false;
$travelami_show_date              = isset($travelami_options[$prefix.'-date'])?filter_var($travelami_options[$prefix.'-date'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_share             = isset($travelami_options[$prefix.'-share'])?filter_var($travelami_options[$prefix.'-share'], FILTER_VALIDATE_BOOLEAN):false;
$travelami_show_title             = isset($travelami_options[$prefix.'-title'])?filter_var($travelami_options[$prefix.'-title'], FILTER_VALIDATE_BOOLEAN):false;
$travelami_show_author            = isset($travelami_options[$prefix.'-author'])?filter_var($travelami_options[$prefix.'-author'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_related           = isset($travelami_options[$prefix.'-related'])?filter_var($travelami_options[$prefix.'-related'], FILTER_VALIDATE_BOOLEAN):false;
$travelami_show_comment           = isset($travelami_options[$prefix.'-comment'])?filter_var($travelami_options[$prefix.'-comment'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_category          = isset($travelami_options[$prefix.'-category'])?filter_var($travelami_options[$prefix.'-category'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_description       = isset($travelami_options[$prefix.'-description'])?filter_var($travelami_options[$prefix.'-description'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_comment_count     = isset($travelami_options[$prefix.'-comment-count'])?filter_var($travelami_options[$prefix.'-comment-count'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_post_view         = isset($travelami_options[$prefix.'-post-view'])?filter_var($travelami_options[$prefix.'-post-view'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_post_next_preview = isset($travelami_options[$prefix.'-next-preview'])?filter_var($travelami_options[$prefix.'-next-preview'], FILTER_VALIDATE_BOOLEAN):false;

$travelami_blog_slider_autoplay   = isset($travelami_options['blog-slider-autoplay'])?filter_var($travelami_options['blog-slider-autoplay'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_blog_thumbnail_size    = isset($travelami_options[$prefix.'-thumbnail-size'])?$travelami_options[$prefix.'-thumbnail-size']:'large';
$travelami_blog_thumbnail_effect  = isset($travelami_options[$prefix.'-thumbnail-effect'])?$travelami_options[$prefix.'-thumbnail-effect']:'none';

$travelami_blog_slider_animation  = isset($travelami_options['blog-slider-animation'])?$travelami_options['blog-slider-animation']:'';
$travelami_blog_slider_nav        = isset($travelami_options['blog-slider-nav'])?filter_var($travelami_options['blog-slider-nav'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_blog_slider_kenburns   = isset($travelami_options['blog-slider-kenburns'])?filter_var($travelami_options['blog-slider-kenburns'], FILTER_VALIDATE_BOOLEAN):true;

$travelami_blog_slider_options = '';
if($travelami_blog_slider_autoplay == true){
    $travelami_blog_slider_options .='autoplay: true; ';
}
if($travelami_blog_slider_animation != ''){
    $travelami_blog_slider_options .='animation: '.$travelami_blog_slider_animation. '';
}
if ( have_posts() ) : while (have_posts()) : the_post() ;
    if ( !empty( get_the_content() ) ){
        $tag_class = 'uk-margin-medium-top ';
    }else{
        $tag_class = '';
    }
?>
<div class="templaza-blog">
    <div id="templaza-single-<?php echo esc_attr($travelami_id); ?>" class="templaza-single templaza-single-<?php
    echo esc_attr($travelami_post_type.' '.$travelami_custom_class); ?> templaza-blog-body">
        <?php
            do_action('templaza_set_postviews',get_the_ID());
            ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class('templaza-blog-item'); ?>>
                <div class="templaza-blog-item-wrap">
                    <div class="templaza-blog-item-content templaza-archive-item ">
                        <div class="templaza-single-content ">
                            <?php
                            if(has_post_thumbnail() || has_post_format('quote') || has_post_format('link')){
                                $post_thumb_cl = '';
                            }else{
                                $post_thumb_cl = 'travelami-no-thumb';
                            }
                            if ($travelami_show_thumbnail
                                && (
                                    has_post_format('gallery')  ||
                                    has_post_format('image')  ||
                                    has_post_format('video') ||
                                    has_post_format('audio') ||
                                    has_post_format('link') ||
                                    has_post_format('quote') ||
                                    has_post_format()==false ) ): ?>
                                <div class="templaza-single-feature uk-position-relative <?php echo esc_attr($post_thumb_cl);?>">

                                    <?php
                                    if (has_post_format('gallery')){
                                        do_action('templaza_gallery_post');
                                    }

                                    if(has_post_thumbnail() && empty(has_post_format('gallery')) && empty(has_post_format('audio'))
                                        && empty(has_post_format('video')) && empty(has_post_format('quote'))&& empty(has_post_format('link'))){
                                        do_action('templaza_image_post');
                                    }
                                    if (has_post_format('video')){
                                        do_action('templaza_video_post');
                                    }
                                    if (has_post_format('audio')){
                                        do_action('templaza_audio_post');
                                    }
                                    if (has_post_format('link')){
                                        do_action('templaza_link_post');
                                    }
                                    if (has_post_format('quote')) {
                                        do_action('templaza_quote_post');
                                    }
                                    ?>
                                </div>
                            <?php
                            endif;
                            if($travelami_show_meta){
	                            do_action('templaza_single_meta_post');
                            }

                            if($travelami_show_title){
	                            do_action('templaza_single_title_post');
                            }

                            ?>
                            <div class="templaza-single-description">
                                <?php
                                $tag_cl = ' ';
                                the_content();
                                wp_link_pages();
                                ?>
                                <div class="clr "></div>

                                <?php
                                if ($travelami_show_tag && has_tag() && get_the_tag_list() || $travelami_show_share !=false) {
                                    ?>
                                    <div class="templaza-single-share-box <?php echo esc_attr($tag_cl); ?> uk-flex uk-flex-between uk-flex-middle">
                                    <?php
                                    if ($travelami_show_tag && has_tag() && get_the_tag_list()){
                                        do_action('templaza_single_tag_post');
                                    }
                                    if($travelami_show_share) {
                                        do_action('templaza_share_post');
                                    }
                                    ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        $post_nav = posts_nav_link();
                        if($travelami_show_post_next_preview){
                        ?>
                            <div class="templaza-single-next-preview templaza-single-box">
                                <?php
                                do_action('templaza_single_next_post');
                                ?>
                            </div>
                        <?php
                        }
                        if($travelami_show_author && get_the_author_meta('description')){
                            ?>
                            <div class="templaza-single-author-box templaza-single-box">
                                <?php
                                do_action('templaza_single_author_post');
                                ?>
                            </div>
                        <?php
                        }
                        if($travelami_show_related){
                            ?>
                            <div class="templaza-single-related templaza-single-box">
                                <?php
                                do_action('templaza_single_related_post');
                                ?>
                            </div>
                        <?php
                        }
                        if($travelami_show_comment && comments_open()){
                            ?>
                            <div class="templaza-single-comment templaza-single-box">
                                <?php
                            comments_template( '', true );
                            ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php
        endwhile; // end while ( have_posts )

        ?>
    </div>
</div>
<?php
endif; // end if ( have_posts )