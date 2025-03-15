<?php
defined('TEMPLAZA_FRAMEWORK') or exit();
if(!class_exists('TemplazaFramework_MetaBox_Product')) {
    class TemplazaFramework_MetaBox_Product extends TemplazaFramework_MetaBox
    {
        public function register(){
            $metaboxes[] = array(
                'id'            => 'product-metabox',
                'title'         => esc_html__( 'Product Options', 'travelami' ),
                'post_types'    => array('product' ),
                'position'      => 'normal', // normal, advanced, side
                'priority'      => 'default', // high, core, default, low - Priorities of placement
                'store_each'    => true, // Store value of each fields to each post meta
                'sections'      => array(
                    array(
                        'fields' => array(
                            array(
                                'id'       => 'product-single-extra-content',
                                'type'     => 'editor',
                                'title'    => esc_html__('Product extra content', 'travelami'),
                                'args'   => array(
                                    'teeny'            => false,
                                    'textarea_rows'    => 10
                                )
                            ),
                        ),
                    ),
                ),
            );

            return $metaboxes;
        }
    }
}