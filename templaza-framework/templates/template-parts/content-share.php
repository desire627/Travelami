<?php
defined('ABSPATH') or exit();
$title = html_entity_decode(get_the_title(get_the_ID()));
$tweet_title = urlencode($title);
?>
<div class="templaza-blog-share uk-flex uk-flex-middle uk-flex-right@s uk-flex-left">
    <label><?php esc_html_e('Share:','travelami');?></label>
    <a class="facebook" title="<?php esc_attr_e('Share on Facebook','travelami');?>" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_the_permalink(get_the_ID())); ?>">
        <i class="fab fa-facebook-f"></i>
    </a>
    <a class="twitter" title="<?php esc_attr_e('Share on Twitter','travelami');?>" target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_the_permalink(get_the_ID())); ?>&text=<?php echo urlencode(get_the_title(get_the_ID())); ?>">
        <i class="fab fa-twitter"></i>
    </a>
    <?php $templaza_pin_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID())); ?>
    <a class="pinterest" title="<?php esc_attr_e('Share on Pinterest','travelami');?>"  data-pin-do="skipLink" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_attr($templaza_pin_image); ?>&description=<?php echo urlencode(get_the_title(get_the_ID())); ?>">
        <i class="fab fa-pinterest"></i>
    </a>
    <a class="linkedin" title="<?php esc_attr_e('Share on Linkedin','travelami');?>"  target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(get_the_ID()); ?>">
        <i class="fab fa-linkedin-in"></i>
    </a>
</div>