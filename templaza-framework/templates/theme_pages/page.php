<?php

use TemPlazaFramework\Functions;
use TemPlazaFramework\Templates;
use TemPlazaFramework\CSS;
if ( class_exists( 'TemPlazaFramework\TemPlazaFramework' ) ) {
    $options = Functions::get_theme_options();

    $menu_color_hover = isset($options['main-menu-link-hover-color']) ? $options['main-menu-link-hover-color'] : '#ffffff';
    if ($menu_color_hover != '') {
        $menu_color_hover  = CSS::make_color_rgba_redux($menu_color_hover);
        Templates::add_inline_style('body .templaza-header .navbar-nav .menu-item:hover >a.item-level-1:before,
        body .templaza-header .navbar-nav .menu-item.current-menu-ancestor >a.item-level-1:before,
        body .templaza-header .navbar-nav .menu-item.current-menu-ancestor >a.item-level-1:after,
        body .templaza-header .navbar-nav .menu-item.current-menu-item >a.item-level-1:after,
        body .templaza-header .navbar-nav .menu-item.current-menu-item >a.item-level-1:before,
         body .templaza-header .navbar-nav .menu-item:hover >a.item-level-1:after{background-color:'.$menu_color_hover.'}');
    }
}
    $id             = isset($atts['id'])?$atts['id']:time();
    $custom_class   = isset($atts['custom-container-class'])?' '.$atts['custom-container-class']:'';
    ?>
<div id="templaza-page-<?php echo esc_attr($id); ?>" class="templaza-page templaza-basic-page-content templaza-page-<?php echo get_post_type().esc_attr($custom_class);?>">
    <?php

    // Start the Loop.
    while ( have_posts() ) :
        the_post();
?>
        <div id="post-<?php the_ID(); ?>" <?php post_class('single-page-box'); ?>>
            <?php
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'travelami' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div>

    <?php

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            ?>
        <div class="single-page-box">
            <?php
                comments_template();
                ?>
        </div>
        <?php
        }
        ?>

        <?php
    endwhile; // End the loop.
    ?>

</div><!-- #main -->
