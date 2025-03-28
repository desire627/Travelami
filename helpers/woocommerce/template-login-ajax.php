<?php
/**
 * Login Popup template hooks.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use TemPlazaFramework\Functions;
/**
 * Class of Login Popup template.
 */
class Templaza_Woo_Login_AJAX {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'account_modal' ) );
		// Authenticate a user, confirming the login credentials are valid.
		add_action( 'wc_ajax_templaza_login_authenticate', array( $this, 'login_authenticate' ) );
		// Handle user registration
		add_action( 'woocommerce_created_customer', array( $this, 'handle_registration_fields' ), 10, 3 );
		// Add validation for registration fields
		add_action( 'woocommerce_register_post', array( $this, 'validate_registration_fields' ), 10, 3 );
		// Ensure password is properly handled during registration
		add_filter( 'woocommerce_registration_generate_password', '__return_false' );
		// Ensure password is properly handled during login
		add_filter( 'woocommerce_login_credentials', array( $this, 'handle_login_credentials' ) );
		// Handle registration redirect
		add_filter( 'woocommerce_registration_redirect', array( $this, 'registration_redirect' ) );
	}

	/**
	 * Display Account Modal
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function account_modal() {
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }
        $modals = isset($templaza_options['templaza-shop-account-login'])?$templaza_options['templaza-shop-account-login']:'modal';
		if ( $modals !='modal' ) {
			return;
		}

		if ( is_user_logged_in() ) {
			return;
		}

		if( function_exists('is_account_page') && is_account_page() ) {
			return;
		}
		?>
        <div id="account-modal" class="account-modal templaza-modal tz-account-modal" tabindex="-1" role="dialog">
            <div class="off-modal-layer"></div>
            <div class="account-panel-content panel-content">
                <?php get_template_part( 'helpers/woocommerce/template-parts/account' ); ?>
            </div>
        </div>
		<?php

	}

	/**
	 * Authenticate a user, confirming the login credentials are valid.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function login_authenticate() {
		check_ajax_referer( 'woocommerce-login', 'security' );

		$creds = array(
			'user_login'    => trim( wp_unslash( $_POST['username'] ) ),
			'user_password' => wp_unslash( $_POST['password'] ),
			'remember'      => isset( $_POST['rememberme'] ),
		);

		// Apply WooCommerce filters
		if ( class_exists( 'WooCommerce' ) ) {
			$validation_error = new \WP_Error();
			$validation_error = apply_filters( 'woocommerce_process_login_errors', $validation_error, $creds['user_login'], $creds['user_password'] );

			if ( $validation_error->get_error_code() ) {
				wp_send_json_error( $validation_error->get_error_message() );
			}

			if ( empty( $creds['user_login'] ) ) {
				wp_send_json_error( esc_html__( 'Username is required.', 'travelami' ) );
			}

			// On multisite, ensure user exists on current site, if not add them before allowing login.
			if ( is_multisite() ) {
				$user_data = get_user_by( is_email( $creds['user_login'] ) ? 'email' : 'login', $creds['user_login'] );

				if ( $user_data && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
					add_user_to_blog( get_current_blog_id(), $user_data->ID, 'customer' );
				}
			}

			$creds = apply_filters( 'woocommerce_login_credentials', $creds );
		}

		// Try to log in with email if username login fails
		if ( ! is_email( $creds['user_login'] ) ) {
			$user = get_user_by( 'login', $creds['user_login'] );
			if ( ! $user ) {
				$user = get_user_by( 'email', $creds['user_login'] );
				if ( $user ) {
					$creds['user_login'] = $user->user_login;
				}
			}
		}

		$user = wp_signon( $creds, is_ssl() );

		if ( is_wp_error( $user ) ) {
			wp_send_json_error( $user->get_error_message() );
		} else {
			wp_send_json_success( array(
				'user' => $user,
				'redirect' => wc_get_account_endpoint_url( 'dashboard' )
			) );
		}
	}

	/**
	 * Validate registration fields
	 *
	 * @since 1.0.0
	 *
	 * @param string $username The username
	 * @param string $email The email
	 * @param WP_Error $validation_error The validation error object
	 * @return void
	 */
	public function validate_registration_fields( $username, $email, $validation_error ) {
		// Validate first name
		if ( empty( $_POST['first_name'] ) ) {
			$validation_error->add( 'first_name_error', __( 'First name is required.', 'travelami' ) );
		} elseif ( strlen( $_POST['first_name'] ) < 2 ) {
			$validation_error->add( 'first_name_error', __( 'First name must be at least 2 characters long.', 'travelami' ) );
		}

		// Validate last name
		if ( empty( $_POST['last_name'] ) ) {
			$validation_error->add( 'last_name_error', __( 'Last name is required.', 'travelami' ) );
		} elseif ( strlen( $_POST['last_name'] ) < 2 ) {
			$validation_error->add( 'last_name_error', __( 'Last name must be at least 2 characters long.', 'travelami' ) );
		}

		// Validate password if not auto-generated
		if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) {
			if ( empty( $_POST['password'] ) ) {
				$validation_error->add( 'password_error', __( 'Password is required.', 'travelami' ) );
			} elseif ( strlen( $_POST['password'] ) < 8 ) {
				$validation_error->add( 'password_error', __( 'Password must be at least 8 characters long.', 'travelami' ) );
			} elseif ( ! preg_match( '/[A-Z]/', $_POST['password'] ) ) {
				$validation_error->add( 'password_error', __( 'Password must contain at least one uppercase letter.', 'travelami' ) );
			} elseif ( ! preg_match( '/[a-z]/', $_POST['password'] ) ) {
				$validation_error->add( 'password_error', __( 'Password must contain at least one lowercase letter.', 'travelami' ) );
			} elseif ( ! preg_match( '/[0-9]/', $_POST['password'] ) ) {
				$validation_error->add( 'password_error', __( 'Password must contain at least one number.', 'travelami' ) );
			}
		}

		// Validate email
		if ( empty( $_POST['email'] ) ) {
			$validation_error->add( 'email_error', __( 'Email is required.', 'travelami' ) );
		} elseif ( ! is_email( $_POST['email'] ) ) {
			$validation_error->add( 'email_error', __( 'Please enter a valid email address.', 'travelami' ) );
		}
	}

	/**
	 * Handle registration redirect
	 *
	 * @param string $redirect The redirect URL
	 * @return string
	 */
	public function registration_redirect( $redirect ) {
		return wc_get_account_endpoint_url( 'dashboard' );
	}

	/**
	 * Handle additional registration fields
	 *
	 * @since 1.0.0
	 *
	 * @param int $customer_id The customer ID
	 * @param array $new_customer_data The new customer data
	 * @param string $password_generated The generated password
	 * @return void
	 */
	public function handle_registration_fields( $customer_id, $new_customer_data, $password_generated ) {
		if ( isset( $_POST['first_name'] ) ) {
			update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
		}
		if ( isset( $_POST['last_name'] ) ) {
			update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
		}

		// Handle password
		if ( isset( $_POST['password'] ) && ! empty( $_POST['password'] ) ) {
			$password = $_POST['password'];
			// Update user password
			wp_set_password( $password, $customer_id );
			
			// Update the new_customer_data to use the provided password
			$new_customer_data['user_pass'] = $password;
		}

		// Ensure email is sent
		$user = get_user_by( 'id', $customer_id );
		if ( $user ) {
			do_action( 'woocommerce_created_customer_notification', $customer_id, $new_customer_data, $password_generated );
		}
	}

	/**
	 * Handle login credentials
	 *
	 * @param array $credentials The login credentials
	 * @return array
	 */
	public function handle_login_credentials( $credentials ) {
		if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
			$credentials['user_login'] = trim( wp_unslash( $_POST['username'] ) );
			$credentials['user_password'] = wp_unslash( $_POST['password'] );
			$credentials['remember'] = isset( $_POST['rememberme'] );
		}
		return $credentials;
	}

	/**
	 * Ensure registration email is sent
	 *
	 * @param int $customer_id The customer ID
	 * @param array $new_customer_data The new customer data
	 * @param string $password_generated The generated password
	 * @return void
	 */
	public function ensure_registration_email( $customer_id, $new_customer_data, $password_generated ) {
		$user = get_user_by( 'id', $customer_id );
		if ( $user ) {
			// Send welcome email
			WC()->mailer()->customer_new_account( $customer_id, $new_customer_data, $password_generated );
			
			// Send admin notification
			WC()->mailer()->admin_new_customer_notification( $customer_id, $new_customer_data );
		}
	}
}
Templaza_Woo_Login_AJAX::get_instance();
