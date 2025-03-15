<?php

if ( function_exists( 'register_block_style' ) ) {

	function travelami_basic_register_block_styles() {

		// Latest Posts: Dividers.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'templaza-latest-posts-dividers',
				'label' => esc_html__( 'Dividers', 'travelami' ),
			)
		);

		// Latest Posts: Borders.
		register_block_style(
			'core/latest-posts',
			array(
				'name'  => 'templaza-latest-posts-borders',
				'label' => esc_html__( 'Borders', 'travelami' ),
			)
		);

		// Media & Text: Borders.
		register_block_style(
			'core/media-text',
			array(
				'name'  => 'templaza-border',
				'label' => esc_html__( 'Borders', 'travelami' ),
			)
		);

		// Gallery Style.
		register_block_style(
			'core/gallery',
			array(
				'name'  => 'templaza-gallery-round',
				'label' => esc_html__( 'Round', 'travelami' ),
			)
		);

		// Heading Style.
		register_block_style(
			'core/heading',
			array(
				'name'  => 'templaza-heading-style1',
				'label' => esc_html__( 'Style1', 'travelami' ),
			)
		);

		// Heading Style.
		register_block_style(
			'core/heading',
			array(
				'name'  => 'templaza-heading-style2',
				'label' => esc_html__( 'Style2', 'travelami' ),
			)
		);

		// Heading Style.
		register_block_style(
			'core/heading',
			array(
				'name'  => 'templaza-heading-style3',
				'label' => esc_html__( 'Style3', 'travelami' ),
			)
		);

	}
	add_action( 'init', 'travelami_basic_register_block_styles' );
}
