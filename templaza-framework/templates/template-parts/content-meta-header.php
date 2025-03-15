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
$show_comment_count = isset($options[$prefix.'-comment-count'])?filter_var($options[$prefix.'-comment-count'], FILTER_VALIDATE_BOOLEAN):false;
$show_author        = isset($options[$prefix.'-author'])?filter_var($options[$prefix.'-author'], FILTER_VALIDATE_BOOLEAN):true;
$show_category      = isset($options[$prefix.'-category'])?filter_var($options[$prefix.'-category'], FILTER_VALIDATE_BOOLEAN):true;
$show_date          = isset($options[$prefix.'-date'])?filter_var($options[$prefix.'-date'], FILTER_VALIDATE_BOOLEAN):true;
$show_post_view     = isset($options[$prefix.'-post-view'])?filter_var($options[$prefix.'-post-view'], FILTER_VALIDATE_BOOLEAN):false;
$show_tag           = isset($options[$prefix.'-tag'])?filter_var($options[$prefix.'-tag'], FILTER_VALIDATE_BOOLEAN):true;
?>
<div class="templaza-post-meta templaza-blog-item-info-top">
    <?php if($show_date){ ?>
        <span class="date">
            <?php
            if(get_the_title() !='') {
                echo esc_html(get_the_date());
            }else{
                ?>
                <a href="<?php the_permalink() ?>"><?php echo esc_html(get_the_date());?></a>
                <?php
            }
            ?>
        </span>
    <?php } ?>
    <?php if($show_author){ ?>
        <span class="author">
            <?php echo esc_html__('By: ', 'travelami') .' '. get_the_author_posts_link();?>
        </span>
    <?php } ?>
    <?php if($show_category && has_term('','category')){
        ?>
        <span class="category">
            <?php the_category(', '); ?>
        </span>
    <?php } ?>
    <?php if ($show_comment_count){ ?>
        <span class="comment_count">
            <?php do_action('templaza_get_commentcount_post'); ?>
        </span>
    <?php } ?>
    <?php if($show_post_view){?>
        <span class="views">
            <?php do_action('templaza_get_postviews',get_the_ID()); ?>
        </span>
    <?php } ?>
    <?php
    if($show_tag && has_tag()){ ?>
        <span class="tag">
            <?php the_tags('',', '); ?>
        </span>
    <?php } ?>
</div>
