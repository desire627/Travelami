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
$show_tag           = isset($options[$prefix.'-tag'])?filter_var($options[$prefix.'-tag'], FILTER_VALIDATE_BOOLEAN):true;
$show_author        = isset($options[$prefix.'-author'])?filter_var($options[$prefix.'-author'], FILTER_VALIDATE_BOOLEAN):true;
$show_date          = isset($options[$prefix.'-date'])?filter_var($options[$prefix.'-date'], FILTER_VALIDATE_BOOLEAN):true;
?>
<div class="uk-card-footer templaza-blog-item-info">
    <?php if($show_author){ ?>
        <span class="author">
            <i class="fas fa-user"></i>
        <?php echo esc_html__('By', 'travelami') .' '. get_the_author_posts_link();?>
        </span>
    <?php } ?>
</div>