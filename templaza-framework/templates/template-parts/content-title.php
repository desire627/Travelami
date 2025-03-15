<?php
defined('ABSPATH') or exit();
?>
<h3 class="templaza-blog-item-title title uk-margin-remove-top">
    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
    <?php
    if(is_sticky(get_the_ID()) && has_post_thumbnail()==false){
        ?>
        <span class="travelami-sticky-post-no-thumbnail"> <?php echo esc_html__('*','travelami');?></span>
        <?php
    }
    ?>
</h3>