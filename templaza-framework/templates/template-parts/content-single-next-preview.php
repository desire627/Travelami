<?php
defined('ABSPATH') or exit();
$next_post = get_next_post();
$prev_post = get_previous_post();
if ( $next_post || $prev_post ) {
    $pagination_classes = '';
    if ( ! $next_post ) {
        $pagination_classes = ' only-one only-prev';
    } elseif ( ! $prev_post ) {
        $pagination_classes = ' only-one only-next';
    }
    ?>
    <div class="uk-clearfix templaza-post-navigation  uk-child-width-1-2@s uk-grid-medium" data-uk-grid>
        <div class="templaza-single-preview-post">
            <?php
            if ( $prev_post ) {
                ?>
                <div class="uk-card uk-grid-collapse uk-child-width-1-2@s uk-margin" data-uk-grid>
                    <div class="uk-width-expand">
                        <a class="previous-post" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
                            <i class="fas fa-angle-left"></i>
                            <span class="title"><?php echo esc_html__('Previous Post','travelami'); ?></span>
                        </a>
                        <h4 class="uk-margin-small-top uk-margin-remove-bottom preview-title">
                            <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
                            <?php echo wp_kses($prev_post->post_title,'post'); ?>
                            </a>
                        </h4>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="templaza-single-next-post uk-text-right">
            <?php
            if ( $next_post ) {
                ?>
                <div class="uk-card uk-grid-collapse uk-child-width-1-2@s uk-margin" data-uk-grid>
                    <div class="uk-width-expand">
                        <div class=" uk-text-right">
                            <a class="previous-post next-post" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
                                <span class="title"><?php echo esc_html__('Next Post','travelami'); ?></span>
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <h4 class="uk-margin-small-top uk-margin-remove-bottom preview-title">
                                <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
                                    <?php echo wp_kses($next_post->post_title,'post'); ?>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}