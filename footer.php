<?php
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' ) ) {
    ?>
    <footer id="colophon" class="site-footer basic-footer" >
        <div class="footer-bottom uk-text-center">
            <div class="uk-container uk-container-large">
                <?php
                printf(
                /* translators: %s: WordPress. */
                    esc_html__( '© Travelami - WordPress Theme 2024. Design by %s', 'travelami' ),
                    '<a href="' . esc_url( 'https://templaza.com/' ) . '">'.esc_html('TemPlaza').'</a>'
                );
                ?>
            </div>
        </div>
    </footer><!-- #colophon -->
<?php
}
wp_footer(); ?>
</body>
</html>
