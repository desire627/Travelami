<?php
defined('ABSPATH') or exit();
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $options = array();
}else{
    $options            = Functions::get_theme_options();
}
$post_type          = get_post_type(get_the_ID());
$prefix             = $post_type.'-page';
if($post_type == 'post'){
    $prefix = 'blog-page';
}
if($post_type == 'post' && is_single()){
    $prefix = 'blog-single';
}
$travelami_layout        = isset($options[$prefix.'-layout'])?$options[$prefix.'-layout']:'list';
$blog_thumbnail_size= isset($options[$prefix.'-thumbnail-size'])?$options[$prefix.'-thumbnail-size']:'large';
$templaza_gallery = get_post_meta(get_the_ID(), '_format_gallery_images', true);
$blog_slider_animation  = isset($options['blog-slider-animation'])?$options['blog-slider-animation']:'';
$blog_thumbnail_effect = isset($options[$prefix.'-thumbnail-effect'])?$options[$prefix.'-thumbnail-effect']:'none';

$blog_slider_kenburns        = isset($options['blog-slider-kenburns'])?filter_var($options['blog-slider-kenburns'], FILTER_VALIDATE_BOOLEAN):true;
$blog_slider_options = '';

$blog_slider_autoplay   = isset($options['blog-slider-autoplay'])?filter_var($options['blog-slider-autoplay'], FILTER_VALIDATE_BOOLEAN):true;
$blog_slider_nav        = isset($options['blog-slider-nav'])?filter_var($options['blog-slider-nav'], FILTER_VALIDATE_BOOLEAN):true;

if($blog_slider_autoplay == true){
    $blog_slider_options .='autoplay: true; ';
}
if($blog_slider_animation != ''){
    $blog_slider_options .='animation: '.$blog_slider_animation. '';
}
if ($templaza_gallery) : ?>
    <div class="templaza-blog-item-media templaza-archive-gallery uk-position-relative uk-visible-toggle uk-light" tabindex="-1" data-uk-slideshow="<?php echo esc_attr($blog_slider_options);?>">
        <ul class="uk-slideshow-items">
            <?php foreach ($templaza_gallery as $templaza_image) : ?>
                <?php $templaza_image_src = wp_get_attachment_image_src($templaza_image,$blog_thumbnail_size );?>
                <?php $templaza_caption = get_post_field('post_excerpt', $templaza_image); ?>
                <li class="templaza-thumbnail-gallery ">
                    <?php
                    if (is_single()) {
                        if($blog_slider_kenburns){?>
                            <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-bottom-left">

                               <img src="<?php echo esc_url($templaza_image_src[0]); ?>"
                                        <?php if ($templaza_caption) { ?> alt="<?php echo esc_attr($templaza_caption); ?>"<?php }else{ ?> alt=" "<?php } ?> data-uk-cover >
                            </div>
                            <?php
                        }else{
                            ?>
                                <img src="<?php echo esc_url($templaza_image_src[0]); ?>"
                                    <?php if ($templaza_caption) { ?> alt="<?php echo esc_attr($templaza_caption); ?>"<?php } else{ ?> alt=" "<?php } ?> data-uk-cover >
                            <?php
                        }
                    }else{
                        if($blog_slider_kenburns){?>
                            <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-bottom-left">
                                <a href="<?php the_permalink() ?>">
                                    <img src="<?php echo esc_url($templaza_image_src[0]); ?>"
                                        <?php if ($templaza_caption) { ?> alt="<?php echo esc_attr($templaza_caption); ?>"<?php }else{ ?> alt=" "<?php } ?> data-uk-cover >
                                </a>
                            </div>
                            <?php
                        }else{
                            ?>
                            <a href="<?php the_permalink() ?>">
                                <img src="<?php echo esc_url($templaza_image_src[0]); ?>"
                                    <?php if ($templaza_caption) { ?> alt="<?php echo esc_attr($templaza_caption); ?>"<?php } else{ ?> alt=" "<?php } ?> data-uk-cover >
                            </a>
                            <?php
                        }
                    }
                    ?>

                </li>
            <?php endforeach; ?>
        </ul>
        <?php if($blog_slider_nav){ ;?>
            <a class="uk-position-center-left" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
            <a class="uk-position-center-right" href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>
            <?php
        }
        ?>
    </div>
<?php
elseif(has_post_thumbnail()): ?>
    <div class="templaza-blog-item-media templaza-blog-item-img templaza-thumbnail-effect templaza-<?php echo esc_attr($blog_thumbnail_effect);?>">
        <a href="<?php the_permalink() ?>">
            <?php the_post_thumbnail($blog_thumbnail_size); ?>
        </a>
    </div>
<?php endif; ?>