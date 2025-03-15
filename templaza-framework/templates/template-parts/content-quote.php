<?php
defined('ABSPATH') or exit();
$templaza_quote_name = get_post_meta(get_the_ID(), '_format_quote_source_author', true);
$templaza_quote_url = get_post_meta(get_the_ID(), '_format_quote_source_url', true);
$templaza_quote_content = get_post_meta(get_the_ID(), '_format_quote_source_content', true);
?>

<?php if($templaza_quote_content){ ?>
<div class="templaza-blog-item-quote">
    <blockquote class="wp-block-quote">
        <p><?php
            echo esc_html($templaza_quote_content);
            ?>
        </p>
        <?php
        if($templaza_quote_name) {
            ?>
            <cite class="uk-display-block"><?php if ($templaza_quote_url) { ?><a href="<?php echo esc_url($templaza_quote_url);?>"><?php } echo esc_html($templaza_quote_name); if ($templaza_quote_url) { ?></a><?php } ?></cite>
            <?php
        }
        ?>
    </blockquote>
</div>
    <?php
}
?>