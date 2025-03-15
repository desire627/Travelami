<?php
defined('ABSPATH') or exit();
if(get_the_author_meta('description')){
?>
<div class="templaza-single-author">
    <div class="templaza-block-author uk-card uk-child-width-1-2@s uk-grid-collapse" data-uk-grid>
        <div class="uk-width-auto templaza-block-author-avata uk-card-media-left ">
            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>">
                <img class="uk-border-circle" width="100" height="100" src="<?php echo esc_url( get_avatar_url( get_the_author_meta('ID'),300) ); ?>" alt="<?php the_author();?>"/>
            </a>
        </div>
        <div class="uk-width-expand templaza-block-author-info">
            <div class="uk-card-body uk-padding-remove-vertical uk-padding-remove-right">
                <h4 class="templaza-block-author-name">
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>">
                        <?php the_author();?>
                    </a>
                </h4>
                <p class="templaza-block-author-desc uk-margin-remove">
                    <?php the_author_meta('description'); ?>
                </p>
                <div class="templaza-block-author-social uk-text-meta  uk-margin-top">
                    <?php do_action('templaza_author_social');?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}