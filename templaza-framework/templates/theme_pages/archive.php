<?php
/*
 * Archive Blog
 */

defined('TEMPLAZA_FRAMEWORK');
use TemPlazaFramework\Functions;
use TemPlazaFramework\Templates;
use TemPlazaFramework\CSS;
$travelami_id             = isset($atts['id'])?$atts['id']:time();
$travelami_custom_class   = isset($atts['custom_container_class'])?' '.$atts['custom_container_class']:'';
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $travelami_options = array();
}else{
    $travelami_options            = Functions::get_theme_options();
}
global $wp_query;
$travelami_post_type      = get_post_type(get_the_ID());
if (!$travelami_post_type) {
	do_action('templaza_search_no_result');
	return;
}

$prefix               = $travelami_post_type.'-page';

if($travelami_post_type == 'post'){
    $prefix = 'blog-page';
}
$travelami_layout        = isset($travelami_options[$prefix.'-layout'])?$travelami_options[$prefix.'-layout']:'list';

$travelami_grid_col      = isset($travelami_options[$prefix.'-grid-column'])?$travelami_options[$prefix.'-grid-column']:2;
$travelami_col_gap      = isset($travelami_options[$prefix.'-column-gap'])?$travelami_options[$prefix.'-column-gap']:'';
$travelami_thumbnail_size= isset($travelami_options[$prefix.'-thumbnail-size'])?$travelami_options[$prefix.'-thumbnail-size']:'large';
$travelami_thumbnail_effect = isset($travelami_options[$prefix.'-thumbnail-effect'])?$travelami_options[$prefix.'-thumbnail-effect']:'none';
$travelami_leading      = isset($travelami_options[$prefix.'-leading'])?filter_var($travelami_options[$prefix.'-leading'], FILTER_VALIDATE_BOOLEAN):false;
$travelami_show_thumbnail     = isset($travelami_options[$prefix.'-thumbnail'])?filter_var($travelami_options[$prefix.'-thumbnail'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_title         = isset($travelami_options[$prefix.'-title'])?filter_var($travelami_options[$prefix.'-title'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_description   = isset($travelami_options[$prefix.'-description'])?filter_var($travelami_options[$prefix.'-description'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_readmore      = isset($travelami_options[$prefix.'-readmore'])?filter_var($travelami_options[$prefix.'-readmore'], FILTER_VALIDATE_BOOLEAN):false;
$travelami_show_share         = isset($travelami_options[$prefix.'-share'])?filter_var($travelami_options[$prefix.'-share'], FILTER_VALIDATE_BOOLEAN):false;
$travelami_show_thumbnail_audio = isset($travelami_options[$prefix.'-thumb-audio'])?filter_var($travelami_options[$prefix.'-thumb-audio'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_thumbnail_video = isset($travelami_options[$prefix.'-thumb-video'])?filter_var($travelami_options[$prefix.'-thumb-video'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_thumbnail_link = isset($travelami_options[$prefix.'-thumb-link'])?filter_var($travelami_options[$prefix.'-thumb-link'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_thumbnail_quote = isset($travelami_options[$prefix.'-thumb-quote'])?filter_var($travelami_options[$prefix.'-thumb-quote'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_show_pagination = isset($travelami_options[$prefix.'-pagination'])?filter_var($travelami_options[$prefix.'-pagination'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_image_cover           = isset($travelami_options[$prefix.'-image-cover'])?filter_var($travelami_options[$prefix.'-image-cover'], FILTER_VALIDATE_BOOLEAN):false;
$travelami_thumbnail_height = isset($travelami_options[$prefix.'-thumbnail-height'])?$travelami_options[$prefix.'-thumbnail-height']:300;
$travelami_card_size = isset($travelami_options[$prefix.'-card-size'])?$travelami_options[$prefix.'-card-size']:'';
$travelami_card_custom = isset($travelami_options[$prefix.'-card-custom'])?$travelami_options[$prefix.'-card-custom']:'';

$travelami_cl = '';
if ($travelami_layout == 'column' || $travelami_layout == 'grid') {
    $travelami_layout_cl = 'templaza-blog-grid uk-child-width-1-'.$travelami_grid_col.'@m';
    $travelami_cl = '';
}else{
    $travelami_layout_cl = 'templaza-blog-list uk-child-width-1-1';
    $travelami_cl = '';
}
$designs    = array(
    array(
        'enable'    => true,
        'class'     => '.templaza-archive-item .uk-card-body',
        'options' => array(
            'blog-page-card-custom',
        ),
    ),
);
if ( class_exists( 'TemPlazaFramework\TemPlazaFramework' ) ) {
    if (count($designs)) {
        $styles = array();

        foreach ($designs as $design) {
            $enable = isset($design['enable']) ? (bool)$design['enable'] : false;
            if ($enable) {
                $wd_css_responsive = array(
                    'desktop' => '',
                    'tablet' => '',
                    'mobile' => '',
                );
                $wd_css = Templates::make_css_design_style($design['options'], $travelami_options);

                if (!empty($wd_css)) {
                    if (is_array($wd_css)) {
                        foreach ($wd_css as $device => $wd_style) {
                            if (!empty($wd_style)) {
                                $wd_style = $design['class'] . '{' . $wd_style . '}';
                                Templates::add_inline_style($wd_style, $device);
                            }
                        }
                    } else {
                        Templates::add_inline_style($design['class'] . '{' . $wd_css . '}');
                    }
                }
            }
        }
    }
    if ($travelami_image_cover == true) {
        $travelami_css = '.templaza-blog-item-img a, .uk-slideshow-items,
     .templaza-blog-item-video .tz-embed-responsive {height: ' . $travelami_thumbnail_height . 'px;}';

        Templates::add_inline_style($travelami_css);
    }
}
?>
<div id="templaza-archive-<?php echo esc_attr($travelami_id);?>" class="templaza-blog templaza-archive templaza-archive-<?php echo esc_attr(get_post_type().$travelami_custom_class); ?>">
    <div class="templaza-blog-body uk-grid-collapse <?php echo esc_attr($travelami_layout_cl. ' uk-grid-'.$travelami_col_gap);?>" data-uk-grid>
        <?php
        $d=1;
        if($wp_query->found_posts==0){
            ?>
            <div class="templaza-blog-item">
            <?php
            do_action('templaza_archive_no_result');
            ?>
            </div>
            <?php
        }
        if (have_posts()) : while (have_posts()) : the_post();
            $format = get_post_format() ? : 'standard';
            if(is_sticky(get_the_ID())){
                $sticky_cl = 'templaza-sticky';
            }else{
                $sticky_cl = '';
            }
            if($travelami_leading && $d==1 && $travelami_layout=='grid'){
                $lead = 'uk-width-1-1';
                $wrap_lead_content = 'templaza-item-lead';
            }else{
                $lead = $wrap_lead_content = ' ';
            }
            if(has_post_thumbnail()){
                $post_thumb_cl = '';
            }else{
                $post_thumb_cl = 'travelami-no-thumb';
            }
            ?>
            <div id='post-<?php the_ID(); ?>' class="<?php echo esc_attr($travelami_cl. ' '.$sticky_cl.' '.$lead); ?> templaza-blog-item ">
                <div class="templaza-blog-item-wrap templaza-archive-item uk-position-relative <?php echo esc_attr($wrap_lead_content);?>">
                    <?php
                    if(is_sticky(get_the_ID()) && has_post_thumbnail()){
                        ?>
                        <span class="templaza-sticky-post" title="<?php echo esc_attr__('Sticky Post','travelami');?>"><i class="fas fa-thumbtack"></i></span>
                        <?php
                    }
                    if ($travelami_show_thumbnail){
                        ?>
                        <div class=" uk-postion-relative <?php echo esc_attr($post_thumb_cl);?>">
                        <?php
                        if($format =='standard'){
                            do_action('templaza_image_post');
                        }
                        if($format =='gallery'){
                            do_action('templaza_gallery_post');
                        }
                        if ($format =='video'&& has_post_thumbnail()) {
                            if ($travelami_show_thumbnail_video){
                                do_action('templaza_image_post');
                            }else{
                                do_action('templaza_video_post');
                            }
                        }
                        if ($format =='audio' && has_post_thumbnail()){
                            if ($travelami_show_thumbnail_audio){
                                do_action('templaza_image_post');
                            }else{
                                do_action('templaza_audio_post');
                            }
                        }
                        if ($format =='link' && has_post_thumbnail()){
                            if ($travelami_show_thumbnail_link){
	                            do_action('templaza_image_post');
                            } else {
	                            do_action('templaza_link_post');
                            }
                        }
                        if ($format == 'quote' && has_post_thumbnail()){
                            if ($travelami_show_thumbnail_quote){
	                            do_action('templaza_image_post');
                            } else {
	                            do_action('templaza_quote_post');
                            }
                        }
                        ?>
                        </div>
                    <?php
                    }
                        ?>
                        <div class="templaza-blog-item-content <?php echo esc_attr($wrap_lead_content);?>">
                            <?php
                            do_action('templaza_meta_post_header');
                            if ($travelami_show_title) {
                                do_action('templaza_title_post');
                            }
                            if ($travelami_show_description) {
                                do_action('templaza_excerpt_post');
                            }
                            if($travelami_show_share || $travelami_show_readmore){
                                ?>
                            <div class="templaza-archive-share-box uk-flex uk-flex-between uk-flex-middle uk-child-width-1-2@s">
                            <?php
                                if ($travelami_show_readmore) {
                                    do_action('templaza_readmore_post');
                                }
                                if ($travelami_show_share) {
                                    do_action('templaza_share_post');
                                }
                                ?>
                            </div>
                                <?php
                            }
                            ?>

                        </div>

                </div>
            </div>
            <?php
            $d++;
        endwhile; // end while ( have_posts )

        endif; // end if ( have_posts )
        ?>
    </div>
    <?php if($travelami_show_pagination){?>
    <div class="templaza-blog-pagenavi uk-margin-top">
        <?php
        do_action('templaza_pagination');
        ?>
    </div>
    <?php } ?>
</div>