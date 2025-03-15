<?php
defined('ABSPATH') or exit();
$templaza_link          = get_post_meta(get_the_ID(), '_format_link_url', true);
$templaza_link_title    = get_post_meta(get_the_ID(), '_format_link_title', true);
if($templaza_link){
?>
<div class="templaza-blog-item-link uk-text-center">
    <div class="link-content">
        <a target="_blank" title="<?php the_title(); ?>"
           href="<?php echo esc_url($templaza_link); ?>">
            <?php echo esc_html($templaza_link_title); ?>
        </a>
    </div>
</div>
<?php
}