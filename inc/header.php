<?php
$wrapper_classes  = 'site-header templaza-header-section basic-header-section';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= ( true === get_theme_mod( 'display_title_and_tagline', true ) ) ? ' has-title-and-tagline' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
$blog_info    = get_bloginfo( 'name' );
$description  = get_bloginfo( 'description', 'display' );
$show_title   = ( true === get_theme_mod( 'display_title_and_tagline', true ) );
$header_class = $show_title ? 'site-title' : 'screen-reader-text';
class travelami_Submenu_Wrap extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='uk-navbar-dropdown'><ul class='uk-nav uk-navbar-dropdown-nav'>\n";
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
}
if(class_exists( 'woocommerce' )){
    if(WC()->cart->get_cart_contents_count() > 0){
        $cart_pro = 'has_product';
    }else{
        $cart_pro = 'no_product';
    }
}
?>

<header id="masthead" class="tz-header-wrap <?php echo esc_attr( $wrapper_classes ); ?>" role="banner" >
    <div class="uk-padding-remove-vertical tz-header-default uk-container uk-container-large ">
        <div class="uk-flex uk-flex-row uk-flex-middle uk-flex-between header-show-icon header-content ">
            <div class="templaza-mobile-btn ">
                <span class="open" data-uk-icon="icon: menu; ratio: 1.6"></span>
                <span class="close" data-uk-icon="icon: close; ratio: 1.6"></span>
            </div>
            <div class="header-left-section site-logo travelami-logo header-horizontal-logo uk-flex uk-flex-between uk-flex-middle mb-logo uk-visible@m ">
                <?php if ( has_custom_logo()) {
                    the_custom_logo();
                }else{
                    ?>
                        <a class="templaza-logo templaza-logo-image" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img class="uk-preserve templaza-logo-default" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/logo.svg');?>" data-uk-svg>
                            <img class="uk-preserve templaza-logo-mobile" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/logo_mobile.svg');?>" data-uk-svg>
                        </a>
                    <?php
                } ?>
            </div>
            <div class="templaza-header templaza-horizontal-header  uk-flex uk-flex-center uk-flex-middle ">
                <div class="uk-hidden@m uk-width-1-1 uk-text-center">
                    <?php if ( has_custom_logo()) {
                        the_custom_logo();
                    }else{
                        ?>
                        <a class="templaza-logo templaza-logo-image" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img class="uk-preserve templaza-logo-default" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/logo.svg');?>" data-uk-svg>
                            <img class="uk-preserve templaza-logo-mobile" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/logo_mobile.svg');?>" data-uk-svg>
                        </a>
                        <?php
                    } ?>
                </div>

                <?php if ( has_nav_menu( 'primary' ) ) : ?>
                    <nav id="site-navigation" class="uk-navbar-container  uk-padding-remove templaza-basic-navbar uk-navbar-transparent" data-uk-navbar>
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location'  => 'primary',
                                'menu_class'      => 'uk-navbar-nav templaza-nav ',
                                'container_class' => 'uk-width-1-1',
                                'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                                'walker'          => new travelami_Submenu_Wrap()
                            )
                        );
                        ?>
                    </nav><!-- #site-navigation -->
                <?php endif; ?>
            </div>

            <div class="uk-flex uk-flex-right uk-flex-middle">
                <?php if(!class_exists( 'TemPlazaFramework\TemPlazaFramework' ) && class_exists( 'woocommerce' )){ ?>
                    <div class="header-cart header-icon <?php echo esc_attr($cart_pro);?>">
                        <a href="<?php echo esc_url( wc_get_cart_url() ) ?>" data-toggle="modal" data-target="cart-modal">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="counter cart-counter"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
                        </a>
                    </div>
                <?php } ?>
            </div>

        </div>

    </div>
</header>