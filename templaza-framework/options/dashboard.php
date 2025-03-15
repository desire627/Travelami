<?php

defined('TEMPLAZA_FRAMEWORK') or exit();

// -> START Portfolio Section
Templaza_API::set_section('settings',
	array(
		'title'      => esc_html__( 'Dashboard', 'travelami' ),
		'id'         => 'dashboard',
		'icon'       => 'el el-th',
		'fields'     => array(
			array(
				'id'       => 'dashboard_number',
				'type'     => 'spinner',
				'title'    => esc_html__('Number Images ', 'travelami'),
				'subtitle' => esc_html__('Number images load in portfolio list','travelami'),
				'default'  => '12',
				'min'      => '3',
				'step'     => '1',
				'max'      => '60',
			),
		)
	)
);