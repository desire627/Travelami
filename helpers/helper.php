<?php
global $content_width;
if ( ! isset( $content_width ) ) {
	$content_width = 580;
}
if ( ! function_exists( 'travelami_basic_fonts_url' ) ) {
	function travelami_basic_fonts_url()
	{
		$travelami_fonts_url = '';
		$travelami_font_families = array();
		$font_subsets = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Barlow, translate this to 'off'. Do not translate into your own language. */
		if ('off' !== esc_html_x('on', 'Jost: on or off', 'travelami')) {
			$travelami_font_families[] = 'Jost:400,500,600,700';
		}

		/* translators: If there are characters in your language that are not supported by Saira, translate this to 'off'. Do not translate into your own language. */
		if ('off' !== esc_html_x('on', 'Marcellus: on or off', 'travelami')) {
			$travelami_font_families[] = 'Marcellus:400';
		}

		if ($travelami_font_families) {

			$travelami_query_args = array(
				'family' => urlencode(implode('|', $travelami_font_families)),
				'subset' => urlencode($font_subsets),
			);

			$travelami_fonts_url = add_query_arg($travelami_query_args, 'https://fonts.googleapis.com/css');
		}
		return esc_url_raw($travelami_fonts_url);
	}
}

if ( !function_exists('travelami_basic_continue_reading_text') ) {
	function travelami_basic_continue_reading_text() {
		$continue_reading = sprintf(
		/* translators: %s: Name of current post. */
			esc_html__( 'Continue reading %s', 'travelami' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		);

		return $continue_reading;
	}
}