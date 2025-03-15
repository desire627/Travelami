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
$blog_thumbnail_size= isset($options[$prefix.'-thumbnail-size'])?$options[$prefix.'-thumbnail-size']:'full';
$blog_thumbnail_effect = isset($options[$prefix.'-thumbnail-effect'])?$options[$prefix.'-thumbnail-effect']:'ripple';
$show_thumbnail     = isset($options[$prefix.'-thumbnail'])?filter_var($options[$prefix.'-thumbnail'], FILTER_VALIDATE_BOOLEAN):true;
$travelami_image_cover = isset($options[$prefix.'-image-cover'])?filter_var($options[$prefix.'-image-cover'], FILTER_VALIDATE_BOOLEAN):false;
if($travelami_image_cover==true){
    $cover_class='tz-image-cover';
}else{
    $cover_class=' ';
}
$ripple_cl = $ripple_html =' ';
if($blog_thumbnail_effect =='ripple'){
    $ripple_html = '<div class="templaza-ripple-circles uk-position-center uk-transition-fade">
                        <div class="circle1"></div>
                        <div class="circle2"></div>
                        <div class="circle3"></div>
                    </div>';
    $ripple_cl = ' templaza-thumb-ripple uk-position-relative uk-transition-toggle';
}
if(has_post_thumbnail()){
?>
<div class="templaza-blog-item-media templaza-blog-item-img templaza-thumbnail-effect templaza-<?php echo esc_attr($blog_thumbnail_effect . $ripple_cl);?>">
    <?php if(is_single()){
        the_post_thumbnail($blog_thumbnail_size,array( 'alt' => '' ));
        echo wp_kses($ripple_html,'post');
    }else{ ?>
    <a class="<?php echo esc_attr($cover_class);?> uk-display-block" href="<?php the_permalink() ?>">
        <?php the_post_thumbnail($blog_thumbnail_size,array( 'alt' => '' ));
        echo wp_kses($ripple_html,'post');
        ?>
    </a>
    <?php } ?>
</div>
<?php
}