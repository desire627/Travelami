<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * functions to manage order
 */
if ( ! class_exists( 'TZbooking_Product_Order_List_Table') ) :
    class TZbooking_Product_Order_List_Table extends WP_List_Table {

        function __construct() {
            global $status, $page;
            parent::__construct( array(
                'singular'  => '_order',     //singular name of the listed records
                'plural'    => 'product_orders',    //plural name of the listed records
                'ajax'      => false        //does this table support ajax?
            ) );
        }

        function column_default( $tzbooking_item, $tzbooking_column_name ) {
            switch( $tzbooking_column_name ) {
                case 'id':
                case 'created':
                case 'total_price':
                    return $tzbooking_item[ $tzbooking_column_name ];
                default:
                    return print_r( $tzbooking_item, true ); //Show the whole array for troubleshooting purposes
            }
        }

        function column_time( $tzbooking_item ) {
            if ( empty( $tzbooking_item['time'] ) || '00:00:00' == $tzbooking_item['time'] ) return '';
            return $tzbooking_item['time'];
        }

        function column_date( $tzbooking_item ) {
            if ( empty( $tzbooking_item['date_from'] ) || '0000-00-00' == $tzbooking_item['date_from'] ) return '';
            return $tzbooking_item['date_from'];
        }

        function column_customer_name( $tzbooking_item ) {
            //Build row actions
            $tzbooking_link_pattern = 'edit.php?post_type=%1s&page=%2$s&action=%3$s&order_id=%4$s';
            $tzbooking_actions = array(
                'edit'      => '<a href="' . esc_url( sprintf( $tzbooking_link_pattern, sanitize_text_field( $_REQUEST['post_type'] ), 'product_orders', 'edit', $tzbooking_item['id'] ) ) . '">Edit</a>',
                'delete'    => '<a href="' . esc_url( sprintf( $tzbooking_link_pattern, sanitize_text_field( $_REQUEST['post_type'] ), 'product_orders', 'delete', $tzbooking_item['id'] . '&_wpnonce=' . wp_create_nonce( 'order_delete' ) ) ) . '">Delete</a>',
            );
            $tzbooking_content = '<a href="' . esc_url( sprintf( $tzbooking_link_pattern, sanitize_text_field( $_REQUEST['post_type'] ), 'product_orders', 'edit', $tzbooking_item['id'] ) ) . '">' . esc_html( $tzbooking_item['first_name'] . ' ' . $tzbooking_item['last_name'] ) . '</a>';
            //Return the title contents
            return sprintf( '%1$s %2$s', $tzbooking_content , $this->row_actions( $tzbooking_actions ) );
        }

        function column_product_name( $tzbooking_item ) {
            return '<a href="' . esc_url( get_edit_post_link( $tzbooking_item['post_id'] ) ) . '">' . esc_html( $tzbooking_item['product_name'] ) . '</a>';
        }

        function column_status( $tzbooking_item ) {
            switch( $tzbooking_item['status'] ) {
                case 'pending':
                    return esc_html__( 'Pending', 'travelami' );
                case 'new':
                    return esc_html__( 'New', 'travelami' );
                case 'confirmed':
                    return esc_html__( 'Confirmed', 'travelami' );
                case 'cancelled':
                    return esc_html__( 'Cancelled', 'travelami' );
            }
            return $tzbooking_item['status'];
        }

        function column_cb( $tzbooking_item ) {
            return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" />', $this->_args['singular'], $tzbooking_item['id'] );
        }

        function get_columns() {
            $tzbooking_columns = array(
                'cb'                => '<input type="checkbox" />', //Render a checkbox instead of text
                'id'                => esc_html__( 'ID', 'travelami' ),
                'customer_name'     => esc_html__( 'Customer Name', 'travelami' ),
                'time'         => esc_html__( 'Time', 'travelami' ),
                'date'         => esc_html__( 'Date', 'travelami' ),
                'product_name'=> esc_html__( 'Tour Name', 'travelami' ),
                'total_price'       => esc_html__( 'Price', 'travelami' ),
                'created'           => esc_html__( 'Created Date', 'travelami' ),
                'status'            => esc_html__( 'Status', 'travelami' ),
            );
            return $tzbooking_columns;
        }

        function get_sortable_columns() {
            $tzbooking_sortable_columns = array(
                'id'           => array( 'id', false ),
                'time'    => array( 'time', false ),
                'date'    => array( 'date', false ),
                'product_name'    => array( 'product_name', false ),
                'status'       => array( 'status', false ),
            );
            return $tzbooking_sortable_columns;
        }

        function get_bulk_actions() {
            $tzbooking_actions = array(
                'bulk_delete'    => 'Delete',
                'bulk_mark_new'    => 'Mark as New',
                'bulk_mark_confirmed'    => 'Mark as Confirmed',
                'bulk_mark_cancelled'    => 'Mark as Cancelled',
            );
            return $tzbooking_actions;
        }

        function process_bulk_action() {
            global $wpdb;
            //Detect when a bulk action is being triggered...

            if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

                $tzbooking_nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
                $tzbooking_action = 'bulk-' . $this->_args['plural'];

                if ( ! wp_verify_nonce( $tzbooking_nonce, $tzbooking_action ) )
                    wp_die( 'Sorry, your nonce did not verify' );
            }

            if ( 'bulk_delete'===$this->current_action() ) {
                $tzbooking_selected_ids = $_GET[ $this->_args['singular'] ];
                $tzbooking_how_many = count($tzbooking_selected_ids);
                $tzbooking_placeholders = array_fill(0, $tzbooking_how_many, '%d');
                $tzbooking_format = implode(', ', $tzbooking_placeholders);

                $tzbooking_current_user_id = get_current_user_id();
                $tzbooking_post_table_name  = esc_sql( $wpdb->prefix . 'posts' );
                $tzbooking_sql = '';

                if ( current_user_can( 'manage_options' ) ) {
                    $tzbooking_sql = sprintf( 'DELETE tzbooking_order, tzbooking_bookings FROM %1$s AS tzbooking_order
				LEFT JOIN %2$s AS tzbooking_bookings ON tzbooking_order.id = tzbooking_bookings.order_id
				WHERE tzbooking_order.id IN (%3$s)', $wpdb->prefix . 'tzbooking_order', $wpdb->prefix . 'tzbooking_product_bookings', "$tzbooking_format" );
                } else {
                    $tzbooking_sql = sprintf( 'DELETE tzbooking_order, tzbooking_bookings FROM %1$s AS tzbooking_order
				LEFT JOIN %2$s AS tzbooking_bookings ON tzbooking_order.id = tzbooking_bookings.order_id
				INNER JOIN %4$s as product ON tzbooking_order.post_id=product.ID
				WHERE tzbooking_order.id IN (%3$s) AND product.post_author = %5$d', $wpdb->prefix . 'tzbooking_order', $wpdb->prefix . 'tzbooking_product_bookings', "$tzbooking_format", $tzbooking_post_table_name, $tzbooking_current_user_id );
                }

                $wpdb->query( $wpdb->prepare( $tzbooking_sql, $tzbooking_selected_ids ) );
            } elseif ( 'bulk_mark_new'===$this->current_action() || 'bulk_mark_confirmed'===$this->current_action() || 'bulk_mark_cancelled'===$this->current_action() ) {
                $tzbooking_selected_ids = $_GET[ $this->_args['singular'] ];
                $tzbooking_how_many = count($tzbooking_selected_ids);
                $tzbooking_placeholders = array_fill(0, $tzbooking_how_many, '%d');
                $tzbooking_format = implode(', ', $tzbooking_placeholders);
                $tzbooking_current_user_id = get_current_user_id();
                $tzbooking_post_table_name  = esc_sql( $wpdb->prefix . 'posts' );
                $tzbooking_sql = '';
                switch( $this->current_action() ) {
                    case 'bulk_mark_new':
                        $tzbooking_status = 'new';
                        break;
                    case 'bulk_mark_confirmed':
                        $tzbooking_status = 'confirmed';
                        break;
                    case 'bulk_mark_cancelled':
                        $tzbooking_status = 'cancelled';
                        break;
                }
                if ( current_user_can( 'manage_options' ) ) {
                    $tzbooking_sql = sprintf( 'UPDATE %1$s AS tzbooking_order
				SET tzbooking_order.status="%2$s"
				WHERE tzbooking_order.id IN (%3$s)', $wpdb->prefix . 'tzbooking_order', $tzbooking_status, "$tzbooking_format" );
                } else {
                    $tzbooking_sql = sprintf( 'UPDATE %1$s AS tzbooking_order
				INNER JOIN %4$s as product ON tzbooking_order.post_id=product.ID
				SET tzbooking_order.status="%2$s"
				WHERE tzbooking_order.id IN (%3$s) AND product.post_author = %5$d', $wpdb->prefix . 'tzbooking_order', $tzbooking_status, "$tzbooking_format", $tzbooking_post_table_name, $tzbooking_current_user_id );
                }
                $wpdb->query( $wpdb->prepare( $tzbooking_sql, $tzbooking_selected_ids ) );
                wp_redirect( admin_url( 'edit.php?post_type=ap_product&page=product_orders&bulk_update=true&items=' . $tzbooking_how_many) );
            }
        }

        function prepare_items() {
            global $wpdb;
            $tzbooking_per_page = 10;
            $tzbooking_columns = $this->get_columns();
            $tzbooking_hidden = array();
            $tzbooking_sortable = $this->get_sortable_columns();

            $this->_column_headers = array( $tzbooking_columns, $tzbooking_hidden, $tzbooking_sortable );
            $this->process_bulk_action();

            $tzbooking_orderby = ( ! empty( $_REQUEST['orderby'] ) ) ? sanitize_sql_orderby( $_REQUEST['orderby'] ) : 'id'; //If no sort, default to title
            $tzbooking_order = ( ! empty( $_REQUEST['order'] ) ) ? sanitize_text_field( $_REQUEST['order'] ) : 'desc'; //If no order, default to desc
            $tzbooking_current_page = $this->get_pagenum();
            $tzbooking_post_table_name  = esc_sql( $wpdb->prefix . 'posts' );

            $tzbooking_where = "1=1";
            $tzbooking_where .= " AND tzbooking_order.post_type='ap_product'";
            if ( ! empty( $_REQUEST['post_id'] ) ) $tzbooking_where .= " AND tzbooking_order.post_id = '" . esc_sql( $_REQUEST['post_id'] ) . "'";
            if ( ! empty( $_REQUEST['date'] ) ) $tzbooking_where .= " AND tzbooking_order.date_from = '" . esc_sql( $_REQUEST['date'] ) . "'";
            if ( ! empty( $_REQUEST['booking_no'] ) ) $tzbooking_where .= " AND tzbooking_order.booking_no = '" . esc_sql( $_REQUEST['booking_no'] ) . "'";
            if ( isset( $_REQUEST['status'] ) ) $tzbooking_where .= " AND tzbooking_order.status = '" . esc_sql( $_REQUEST['status'] ) . "'";
            if ( ! current_user_can( 'manage_options' ) ) { $tzbooking_where .= " AND product.post_author = '" . get_current_user_id() . "' "; }

            $tzbooking_sql = $wpdb->prepare( 'SELECT tzbooking_order.*, product.ID as post_id, product.post_title as product_name FROM %1$s as tzbooking_order
						INNER JOIN %2$s as product ON tzbooking_order.post_id=product.ID
						WHERE ' . $tzbooking_where . ' ORDER BY %3$s %4$s
						LIMIT %5$s, %6$s' , $wpdb->prefix . 'tzbooking_order', $tzbooking_post_table_name, $tzbooking_orderby, $tzbooking_order, $tzbooking_per_page * ( $tzbooking_current_page - 1 ), $tzbooking_per_page );
            $tzbooking_data = $wpdb->get_results( $tzbooking_sql, ARRAY_A );

            $tzbooking_sql = sprintf( 'SELECT COUNT(*) FROM %1$s as tzbooking_order INNER JOIN %2$s as product ON tzbooking_order.post_id=product.ID WHERE %3$s' , $wpdb->prefix . 'tzbooking_order', $tzbooking_post_table_name, $tzbooking_where );
            $tzbooking_total_items = $wpdb->get_var( $tzbooking_sql );

            $this->items = $tzbooking_data;
            $this->set_pagination_args( array(
                'total_items' => $tzbooking_total_items,                  //WE have to calculate the total number of items
                'per_page'    => $tzbooking_per_page,                     //WE have to determine how many items to show on a page
                'total_pages' => ceil( $tzbooking_total_items/$tzbooking_per_page )   //WE have to calculate the total number of pages
            ) );
        }
    }
endif;

/*
 * add order list page to menu
 */
if ( ! function_exists( 'tzbooking_product_order_add_menu_items' ) ) {
    function tzbooking_product_order_add_menu_items() {
        //add product orders list page
        $tzbooking_page = add_submenu_page( 'edit.php?post_type=ap_product', 'Product Orders', 'Orders', 'manage_options', 'product_orders', 'tzbooking_product_order_render_pages' );
        add_action( 'admin_print_scripts-' . $tzbooking_page, 'tzbooking_product_order_admin_enqueue_scripts' );
    }
}

/*
 * order admin main actions
 */
if ( ! function_exists( 'tzbooking_product_order_render_pages' ) ) {
    function tzbooking_product_order_render_pages() {
        if ( ( ! empty( $_REQUEST['action'] ) ) && ( ( 'add' == $_REQUEST['action'] ) || ( 'edit' == $_REQUEST['action'] ) ) ) {
            tzbooking_product_order_render_manage_page();
        } elseif ( ( ! empty( $_REQUEST['action'] ) ) && ( 'delete' == $_REQUEST['action'] ) ) {
            tzbooking_product_order_delete_action();
        } else {
            tzbooking_product_order_render_list_page();
        }
    }
}

/*
 * render order list page
 */
if ( ! function_exists( 'tzbooking_product_order_render_list_page' ) ) {
    function tzbooking_product_order_render_list_page() {
        global $wpdb;
        $tzbooking_order_table = new TZbooking_Product_Order_List_Table();
        $tzbooking_order_table->prepare_items();

        ?>

        <div class="wrap">

            <h2><?php echo esc_html__('Product Orders','travelami') ?> <a href="edit.php?post_type=ap_product&amp;page=product_orders&amp;action=add" class="add-new-h2"><?php echo esc_html__('Add New','travelami') ?></a></h2>
            <?php if ( isset( $_REQUEST['bulk_delete'] ) && isset( $_REQUEST['items'] ) ) echo '<div id="message" class="updated below-h2"><p>' . esc_html( sprintf( esc_html__( '%d orders deleted', 'travelami' ), $_REQUEST['items'] ) ) . '</p></div>'?>
            <?php if ( isset( $_REQUEST['bulk_update'] ) && isset( $_REQUEST['items'] ) ) echo '<div id="message" class="updated below-h2"><p>' . esc_html( sprintf( esc_html__( '%d orders updated', 'travelami' ), $_REQUEST['items'] ) ) . '</p></div>'?>
            <select id="product_filter">
                <option></option>
                <?php
                $tzbooking_args = array(
                    'post_type'         => 'ap_product',
                    'posts_per_page'    => -1,
                    'orderby'           => 'title',
                    'order'             => 'ASC'
                );
                if ( ! current_user_can( 'manage_options' ) ) {
                    $tzbooking_args['author'] = get_current_user_id();
                }
                $tzbooking_product_query = new WP_Query( $tzbooking_args );

                if ( $tzbooking_product_query->have_posts() ) {
                    while ( $tzbooking_product_query->have_posts() ) {
                        $tzbooking_product_query->the_post();
                        $tzbooking_selected = '';
                        $tzbooking_id = $tzbooking_product_query->post->ID;
                        if ( ! empty( $_REQUEST['post_id'] ) && ( $_REQUEST['post_id'] == $tzbooking_id ) ) $tzbooking_selected = ' selected ';
                        echo '<option ' . esc_attr( $tzbooking_selected ) . 'value="' . esc_attr( $tzbooking_id ) .'">' . wp_kses_post( get_the_title( $tzbooking_id ) ) . '</option>';
                    }
                } else {
                    // no posts found
                }
                /* Restore original Post Data */
                wp_reset_postdata();
                ?>
            </select>
            <input type="date" id="date_filter" name="date" placeholder="<?php echo esc_html__( 'Filter by Date', 'travelami' ) ?>" value="<?php if ( ! empty( $_REQUEST['date'] ) ) echo esc_attr( $_REQUEST['date'] ); ?>">
            <input type="text" id="booking_no_filter" name="booking_no" placeholder="<?php echo esc_html__( 'Filter by Booking No', 'travelami' ) ?>" value="<?php if ( ! empty( $_REQUEST['booking_no'] ) ) echo esc_attr( $_REQUEST['booking_no'] ); ?>">
            <select name="status" id="status_filter">
                <option value=""><?php echo esc_html__( 'select a status', 'travelami' ) ?></option>
                <?php
                $tzbooking_statuses = array( 'new' => esc_html__( 'New', 'travelami' ), 'confirmed' => esc_html__( 'Confirmed', 'travelami' ), 'cancelled' => esc_html__( 'Cancelled', 'travelami' ), 'pending' => esc_html__( 'Pending', 'travelami' ) );
                foreach( $tzbooking_statuses as $tzbooking_key=>$tzbooking_status ) { ?>
                    <option value="<?php echo esc_attr( $tzbooking_key ) ?>" <?php selected( $tzbooking_key, isset( $_REQUEST['status'] ) ? esc_attr( $_REQUEST['status'] ) : '' ); ?>><?php echo esc_attr( $tzbooking_status ) ?></option>
                <?php } ?>
            </select>
            <input type="button" name="order_filter" id="product-order-filter" class="button" value="Filter">
            <a href="edit.php?post_type=ap_product&amp;page=product_orders" class="button-secondary"><?php echo esc_html__( 'Show All', 'travelami' ) ?></a>
            <form id="accomo-orders-filter" method="get">
                <input type="hidden" name="post_type" value="<?php echo esc_attr( $_REQUEST['post_type'] ) ?>" />
                <input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ) ?>" />
                <?php $tzbooking_order_table->display() ?>
            </form>

        </div>
        <style>#date_filter, #date_to_filter {width:150px;}</style>
        <?php
    }
}

/*
 * render order detail page
 */
if ( ! function_exists( 'tzbooking_product_order_render_manage_page' ) ) {
    function tzbooking_product_order_render_manage_page() {
        global $wpdb, $tzbooking_options;
        if ( ! empty( $_POST['save'] ) ) {
            tzbooking_product_order_save_action();
            return;
        }

        $tzbooking_order_data = array();
        $tzbooking_product_data = array();

        if ( 'edit' == $_REQUEST['action'] ) {

            if ( empty( $_REQUEST['order_id'] ) ) {
                echo "<h2>" . esc_html__( "You attempted to edit an item that doesn't exist. Perhaps it was deleted?" , "travelami" ) . "</h2>";
                return;
            }

            $tzbooking_order_id = $_REQUEST['order_id'];
            $tzbooking_post_table_name = $wpdb->prefix . 'posts';

            $tzbooking_order = new TZbooking_Product_Order( $tzbooking_order_id );
            $tzbooking_order_data = $tzbooking_order->tzbooking_get_order_info();
            $tzbooking_product_data = $tzbooking_order->tzbooking_get_products();

            if ( empty( $tzbooking_order_data ) ) {
                echo "<h2>" . esc_html__( "You attempted to edit an item that doesn't exist. Perhaps it was deleted?" , "travelami" ) . "</h2>";
                return;
            }
        }

        $tzbooking_default_order_data = tzbooking_order_default_order_data();
        $tzbooking_order_data = array_replace( $tzbooking_default_order_data , $tzbooking_order_data );
        $tzbooking_site_currency_symbol = get_option('options_ap_currency_symbol', '$');

        ?>

        <div class="wrap">
            <?php $tzbooking_page_title = ( 'edit' == $_REQUEST['action'] ) ? esc_html__('Edit Tour Order','travelami'). '<a href="edit.php?post_type=ap_product&amp;page=product_orders&amp;action=add" class="add-new-h2">'. esc_html__('Add New','travelami') .'</a>' : esc_html__('Add New Tour Order','travelami'); ?>
            <h2><?php echo wp_kses_post( $tzbooking_page_title ); ?></h2>
            <?php if ( isset( $_REQUEST['updated'] ) ) echo '<div id="message" class="updated below-h2"><p>'. esc_html__('Order saved','travelami') .'</p></div>'?>
            <form method="post" id="order-form" class="product-order-form" onsubmit="return manage_order_validateForm();" data-message="<?php echo esc_attr( esc_html__( 'Please select a tour', 'travelami' ) ) ?>">
                <input type="hidden" name="id" value="<?php echo esc_attr( $tzbooking_order_data['id'] ); ?>">
                <div class="row postbox uk-grid uk-padding" data-uk-grid>
                    <div class="one-half uk-width-1-2@s uk-width-1-1">
                        <h3><?php echo esc_html__( 'Order Detail', 'travelami' ) ?></h3>
                        <table class="ct_admin_table ct_order_manage_table">
                            <tr>
                                <th><?php echo esc_html__( 'Tour', 'travelami' ) ?></th>
                                <td>
                                    <select name="post_id" id="post_id">
                                        <option></option>
                                        <?php
                                        $tzbooking_args = array(
                                            'post_type'         => 'ap_product',
                                            'posts_per_page'    => -1,
                                            'orderby'           => 'title',
                                            'order'             => 'ASC'
                                        );
                                        if ( ! current_user_can( 'manage_options' ) ) {
                                            $tzbooking_args['author'] = get_current_user_id();
                                        }
                                        $tzbooking_product_query = new WP_Query( $tzbooking_args );

                                        if ( $tzbooking_product_query->have_posts() ) {
                                            while ( $tzbooking_product_query->have_posts() ) {
                                                $tzbooking_product_query->the_post();
                                                $tzbooking_selected = '';
                                                $tzbooking_id = $tzbooking_product_query->post->ID;
                                                if ( $tzbooking_order_data['post_id'] == $tzbooking_id ) $tzbooking_selected = ' selected ';
                                                echo '<option ' . esc_attr( $tzbooking_selected ) . 'value="' . esc_attr( $tzbooking_id ) .'">' . wp_kses_post( get_the_title( $tzbooking_id ) ) . '</option>';
                                            }
                                        }
                                        wp_reset_postdata();
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Time', 'travelami' ) ?></th>
                                <td><input type="text" name="time" id="time" value="<?php echo esc_attr( $tzbooking_order_data['time'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Date', 'travelami' ) ?></th>
                                <td><input type="text" name="date_from" id="date" value="<?php echo esc_attr( $tzbooking_order_data['date_from'] ) ?>"></td>
                            </tr>
                            <?php
                            if( $tzbooking_order_data['price_combo'] != '0'){?>
                                <tr>
                                    <th><?php echo esc_html__( 'Name Combo', 'travelami' ) ?></th>
                                    <td><input type="text" name="name_combo" value="<?php echo esc_attr( $tzbooking_order_data['name_combo'] ) ?>"></td>
                                </tr>

                                <tr>
                                    <th><?php echo esc_html__( 'People Combo', 'travelami' ) ?></th>
                                    <td><input type="text" name="people_combo" value="<?php echo esc_attr( $tzbooking_order_data['people_combo'] ) ?>"></td>
                                </tr>

                                <tr>
                                    <th><?php echo esc_html__( 'Price Combo', 'travelami' ) ?></th>
                                    <td><input type="text" name="price_combo" value="<?php echo esc_attr( $tzbooking_order_data['price_combo'] ) ?>"> <?php echo esc_html( $tzbooking_site_currency_symbol ) ?></td>
                                </tr>
                                <?php
                            }else{ ?>
                                <tr>
                                    <th><?php echo esc_html__( 'Total Adults', 'travelami' ) ?></th>
                                    <td><input type="number" name="total_adults" value="<?php echo esc_attr( $tzbooking_order_data['total_adults'] ) ?>"></td>
                                </tr>
                                <tr>
                                    <th><?php echo esc_html__( 'Total Children', 'travelami' ) ?></th>
                                    <td><input type="number" name="total_kids" value="<?php echo esc_attr( $tzbooking_order_data['total_kids'] ) ?>"></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th><?php echo esc_html__( 'Total Price', 'travelami' ) ?></th>
                                <td><input type="text" name="total_price" value="<?php echo esc_attr( $tzbooking_order_data['total_price'] ) ?>"> <?php echo esc_html( $tzbooking_site_currency_symbol ) ?></td>
                            </tr>

                            <tr>
                                <th><?php echo esc_html__( 'Payment Method', 'travelami' ) ?></th>
                                <td>
                                    <select name="payment_method">
                                        <?php $tzbooking_payment_methods = array( 'cash' => esc_html__( 'Payment by cash', 'travelami' ), 'paypal' => esc_html__( 'Payment by paypal', 'travelami' ), 'cc' => esc_html__( 'Payment by credit card', 'travelami' ));
                                        if ( ! isset( $tzbooking_order_data['payment_method'] ) ) {
                                            $tzbooking_order_data['payment_method'] = '';
                                        }
                                        ?>
                                        <?php foreach ( $tzbooking_payment_methods as $tzbooking_method_key => $tzbooking_method_name) { ?>
                                            <option value="<?php echo esc_attr( $tzbooking_method_key ) ?>" <?php selected( $tzbooking_method_key, $tzbooking_order_data['payment_method'] ); ?>><?php echo esc_html( $tzbooking_method_name ) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th><?php echo esc_html__( 'Status', 'travelami' ) ?></th>
                                <td>
                                    <select name="status">
                                        <?php $tzbooking_statuses = array( 'new' => esc_html__( 'New', 'travelami' ), 'confirmed' => esc_html__( 'Confirmed', 'travelami' ), 'cancelled' => esc_html__( 'Cancelled', 'travelami' ), 'pending' => esc_html__( 'Pending', 'travelami' ) );
                                        if ( ! isset( $tzbooking_order_data['status'] ) ) {
                                            $tzbooking_order_data['status'] = 'new';
                                        }
                                        ?>
                                        <?php foreach ( $tzbooking_statuses as $tzbooking_key => $tzbooking_content) { ?>
                                            <option value="<?php echo esc_attr( $tzbooking_key ) ?>" <?php selected( $tzbooking_key, $tzbooking_order_data['status'] ); ?>><?php echo esc_html( $tzbooking_content ) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class="one-half uk-width-1-2@s uk-width-1-1">
                        <h3><?php echo esc_html__( 'Customer Infomation', 'travelami' ) ?></h3>
                        <table  class="ct_admin_table ct_order_manage_table">
                            <tr>
                                <th><?php echo esc_html__( 'First Name', 'travelami' ) ?></th>
                                <td><input type="text" name="first_name" value="<?php echo esc_attr( $tzbooking_order_data['first_name'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Last Name', 'travelami' ) ?></th>
                                <td><input type="text" name="last_name" value="<?php echo esc_attr( $tzbooking_order_data['last_name'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Email', 'travelami' ) ?></th>
                                <td><input type="email" name="email" value="<?php echo esc_attr( $tzbooking_order_data['email'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Phone', 'travelami' ) ?></th>
                                <td><input type="text" name="phone" value="<?php echo esc_attr( $tzbooking_order_data['phone'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Address', 'travelami' ) ?></th>
                                <td><input type="text" name="address" value="<?php echo esc_attr( $tzbooking_order_data['address'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'City', 'travelami' ) ?></th>
                                <td><input type="text" name="city" value="<?php echo esc_attr( $tzbooking_order_data['city'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'State', 'travelami' ) ?></th>
                                <td><input type="text" name="state" value="<?php echo esc_attr( $tzbooking_order_data['state'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Postal Code', 'travelami' ) ?></th>
                                <td><input type="text" name="zip" value="<?php echo esc_attr( $tzbooking_order_data['zip'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Country', 'travelami' ) ?></th>
                                <td><input type="text" name="country" value="<?php echo esc_attr( $tzbooking_order_data['country'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Order notes', 'travelami' ) ?></th>
                                <td><textarea name="order_notes"><?php echo esc_textarea( stripslashes( $tzbooking_order_data['order_notes'] ) ) ?></textarea></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Booking No', 'travelami' ) ?></th>
                                <td><input type="text" name="booking_no" value="<?php echo esc_attr( $tzbooking_order_data['booking_no'] ) ?>"></td>
                            </tr>
                            <tr>
                                <th><?php echo esc_html__( 'Pin Code', 'travelami' ) ?></th>
                                <td><input type="text" name="pin_code" value="<?php echo esc_attr( $tzbooking_order_data['pin_code'] ) ?>"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="uk-margin-top">
                    <input type="hidden" name="product_booking_id" value="<?php echo esc_attr( ( empty( $tzbooking_product_data ) || empty( $tzbooking_product_data['id'] ) ) ? '' : $tzbooking_product_data['id'] ); ?>">
                    <input type="submit" class="button-primary button_save_order" name="save" value="Save order">
                    <a href="edit.php?post_type=ap_product&amp;page=product_orders" class="button-secondary"><?php echo esc_html__('Cancel','travelami'); ?></a>
                    <?php wp_nonce_field('tzbooking_orders_detail','order_save'); ?>
                </div>
            </form>
        </div>
        <?php
    }
}

/*
 * order delete action
 */
if ( ! function_exists( 'tzbooking_product_order_delete_action' ) ) {
    function tzbooking_product_order_delete_action() {
        global $wpdb;
        // data validation
        if ( empty( $_REQUEST['order_id'] ) ) {
            print esc_html__( 'Sorry, you tried to remove nothing.', 'travelami' );
            exit;
        }

        // nonce check
        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'order_delete' ) ) {
            print esc_html__( 'Sorry, your nonce did not verify.', 'travelami' );
            exit;
        }

        // check ownership if user is not admin
        if ( ! current_user_can( 'manage_options' ) ) {
            $tzbooking_sql = $wpdb->prepare( 'SELECT tzbooking_order.post_id FROM %1$s as tzbooking_order WHERE tzbooking_order.id = %2$d' , $wpdb->prefix . 'tzbooking_order', $_REQUEST['order_id'] );
            $tzbooking_post_id = $wpdb->get_var( $tzbooking_sql );
            $tzbooking_post_author_id = get_post_field( 'post_author', $tzbooking_post_id );
            if ( get_current_user_id() != $tzbooking_post_author_id ) {
                print esc_html__( 'You don\'t have permission to remove other\'s item.', 'travelami' );
                exit;
            }
        }

        // do action
        $tzbooking_sql = sprintf( 'DELETE tzbooking_order, tzbooking_bookings FROM %1$s AS tzbooking_order
		LEFT JOIN %2$s AS tzbooking_bookings ON tzbooking_order.id = tzbooking_bookings.order_id
		WHERE tzbooking_order.id = %3$s', $wpdb->prefix . 'tzbooking_order', $wpdb->prefix . 'tzbooking_product_bookings', '%d' );
        $wpdb->query( $wpdb->prepare( $tzbooking_sql, $_REQUEST['order_id'] ) );
        wp_redirect( admin_url( 'edit.php?post_type=ap_product&page=product_orders') );
        exit;
    }
}

/*
 * order save action
 */
if ( ! function_exists( 'tzbooking_product_order_save_action' ) ) {
    function tzbooking_product_order_save_action() {
        //validation
        if ( ! isset( $_POST['order_save'] ) || ! wp_verify_nonce( $_POST['order_save'], 'tzbooking_orders_detail' ) ) {
            print esc_html__( 'Sorry, your nonce did not verify.', 'travelami' );
            exit;
        }

        if ( empty( $_POST['post_id'] ) || 'ap_product' != get_post_type( $_POST['post_id'] ) ) {
            print esc_html__( 'Invalid Product ID.', 'travelami' );
            exit;
        }

        global $wpdb;
        $tzbooking_default_order_data = tzbooking_order_default_order_data( 'update' );

        $tzbooking_order_data = array();
        foreach ( $tzbooking_default_order_data as $tzbooking_table_field => $tzbooking_def_value ) {
            if ( isset( $_POST[ $tzbooking_table_field ] ) ) {
                $tzbooking_order_data[ $tzbooking_table_field ] = $_POST[ $tzbooking_table_field ];
                if ( ! is_array( $_POST[ $tzbooking_table_field ] ) ) {
                    $tzbooking_order_data[ $tzbooking_table_field ] = sanitize_text_field( $tzbooking_order_data[ $tzbooking_table_field ] );
                } else {
                    $tzbooking_order_data[ $tzbooking_table_field ] = serialize( $tzbooking_order_data[ $tzbooking_table_field ] );
                }
            }
        }

        $tzbooking_order_data = array_replace( $tzbooking_default_order_data, $tzbooking_order_data );
        $tzbooking_order_data['post_id'] = $tzbooking_order_data['post_id'];
        if ( empty( $_POST['id'] ) ) {
            //insert
            $tzbooking_order_data['created'] = date( 'Y-m-d H:i:s' );
            $tzbooking_order_data['post_type'] = 'ap_product';
            $wpdb->insert( $wpdb->prefix . 'tzbooking_order', $tzbooking_order_data );
            $tzbooking_order_id = $wpdb->insert_id;

        } else {
            //update
            $wpdb->update( $wpdb->prefix . 'tzbooking_order', $tzbooking_order_data, array( 'id' => sanitize_text_field( $_POST['id'] ) ) );
            $tzbooking_order_id = sanitize_text_field( $_POST['id'] );

        }

        $tzbooking_product_data = array(
            'product_id' => $tzbooking_order_data['post_id'],
            'booking_time' => $tzbooking_order_data['time'],
            'booking_date' => $tzbooking_order_data['date_from'],
            'adults' => $tzbooking_order_data['total_adults'],
            'kids' => $tzbooking_order_data['total_kids'],
            'total_price' => $tzbooking_order_data['total_price'],
            'order_id' => $tzbooking_order_id,
        );

        // update product booking table
        $tzbooking_sql = 'DELETE FROM ' . $wpdb->prefix . 'tzbooking_product_bookings' . ' WHERE order_id=%d';
        $wpdb->query( $wpdb->prepare( $tzbooking_sql, $tzbooking_order_id ) );
        $tzbooking_format = array( '%d', '%s', '%d', '%d', '%f', '%d' );
        if ( ! empty( $_POST['product_booking_id'] ) ) {
            $tzbooking_product_data['id'] = $_POST['product_booking_id'];
            $tzbooking_format[] = '%d';
        }
        $wpdb->insert( $wpdb->prefix . 'tzbooking_product_bookings', $tzbooking_product_data, $tzbooking_format ); // add additional services

        wp_redirect( admin_url( 'edit.php?post_type=ap_product&page=product_orders&action=edit&test=1&order_id=' . $tzbooking_order_id . '&updated=true') );
        exit;
    }
}

/*
 * order admin enqueue script action
 */
if ( ! function_exists( 'tzbooking_product_order_admin_enqueue_scripts' ) ) {
    function tzbooking_product_order_admin_enqueue_scripts() {


        wp_enqueue_script( 'jquery-ui-datepicker' );

        // You need styling for the datepicker. For simplicity I've linked to the jQuery UI CSS on a CDN.
        wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.13.3/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );

        wp_enqueue_script( 'jquery-ui-sortable' );

        // custom style and js
        wp_enqueue_script('tzbooking-order-admin-script', get_template_directory_uri() . '/booking/assets/js/order-admin.js', array('jquery'), false, true );
    }
}
add_action( 'admin_menu', 'tzbooking_product_order_add_menu_items' );