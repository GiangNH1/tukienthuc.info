<?php
/**
 * Handles logic for the admin settings page.
 *
 * @since 1.0.0
 */
final class HPR {

	/**
	 * The single instance of the class.
	 *
	 * @var Hotline_Phone_Ring
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Hotline_Phone_Ring Instance.
	 *
	 * Ensures only one instance of Hotline_Phone_Ring is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Hotline_Phone_Ring - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init_hooks' ) );
	}

	/**
	 * Adds the admin menu
	 * the plugin's admin settings page.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_head', array( $this, 'frontend_custom_style' ) );
		add_action( 'wp_footer', array( $this, 'frontend' ) );
		add_filter( 'plugin_action_links_' . HPR_BASE_NAME, array( $this, 'add_action_links' ) );
		add_filter( 'plugin_row_meta', array( $this, 'add_row_meta' ), 10, 4 );
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 500 );

		if ( isset( $_REQUEST['page'] ) && 'hotline-phone-ring' == $_REQUEST['page'] ) {
			$this->save();
		}
	}

	/**
	 * Enqueue frontend styles & scripts.
	 */
	public function enqueue_scripts() {
		$data = $this->data();
		if ( 'style1' == $data['style'] ) {
			wp_enqueue_style( 'hpr-style', HPR_ASSETS_URL . 'css/style-1.css', array(), HPR_VERSION );
		} elseif ( 'style2' == $data['style'] ) {
			wp_enqueue_style( 'hpr-style', HPR_ASSETS_URL . 'css/style-2.css', array(), HPR_VERSION );
		}
	}

	/**
	 * Enqueue admin styles & scripts.
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'hpr-admin-script', HPR_ASSETS_URL . 'js/admin.js', array( 'jquery', 'wp-color-picker' ), HPR_VERSION, true );
	}

	/**
	 * Register admin settings menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function menu() {
		if ( is_main_site() || ! is_multisite() ) {
			if ( current_user_can( 'manage_options' ) ) {

				$title    = esc_html__( 'HPR Options', 'hotline-phone-ring' );
				$cap      = 'manage_options';
				$slug     = 'hotline-phone-ring';
				$func     = array( $this, 'backend' );
				$icon     = 'dashicons-phone';
				$position = 500;

				add_menu_page( $title, $title, $cap, $slug, $func, $icon, $position );
			}
		}
	}

	/**
	 * Get settings data.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function data() {
		$defaults = array(
			'phone'          => '0987654321',
			'style'          => 'style1',
			'color'          => '',
			'hotline_bar'    => '',
			'space_vertical' => '20px',
			'space_horizon'  => '20px',
			'position'       => 'left',
		);

		$data = $this->option( 'hpr_options', true );

		if ( ! is_array( $data ) || empty( $data ) ) {
			return $defaults;
		}

		if ( is_array( $data ) && ! empty( $data ) ) {
			return wp_parse_args( $data, $defaults );
		}
	}

	/**
	 * Renders the update message.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function message() {
		if ( ! empty( $_POST ) ) {
			echo '<div class="updated"><p>' . esc_html__( 'Settings updated!', 'hotline-phone-ring' ) . '</p></div>';
		}
	}

	/**
	 * Admin html form setting.
	 *
	 * @return [type] [description]
	 */
	public function backend() {
		include HPR_PATH . 'includes/backend.php';
	}

	/**
	 * Hotline phone ring frontend template.
	 * @return [type] [description]
	 */
	public function frontend() {
		$data = $this->data();

		$hotline_bar = 'off';
		if ( ! empty( $data['hotline_bar'] ) ) {
			$hotline_bar = $data['hotline_bar'];
		}

		$hotline = '';
		if ( ! empty( $data['phone'] ) ) {
			$hotline = $data['phone'];
		} else {
			return;
		}
		?>
		<div class="hotline-phone-ring-wrap">
			<div class="hotline-phone-ring">
				<div class="hotline-phone-ring-circle"></div>
				<div class="hotline-phone-ring-circle-fill"></div>
				<div class="hotline-phone-ring-img-circle">
					<a href="tel:<?php echo preg_replace( '/\D/', '', $hotline ); ?>" class="pps-btn-img">
						<?php if ( 'style1' == $data['style'] ) {
							$icon = HPR_ASSETS_URL . 'images/icon-1.png';
						} else {
							$icon = HPR_ASSETS_URL . 'images/icon-2.png';
						} ?>
						<img src="<?php echo $icon; ?>" alt="<?php esc_html_e( 'Hotline', 'hotline-phone-ring' ); ?>" width="50" />
					</a>
				</div>
			</div>
			<?php if ( 'off' === $hotline_bar ) : ?>
			<div class="hotline-bar">
				<a href="tel:<?php echo preg_replace( '/\D/', '', $hotline ); ?>">
					<span class="text-hotline"><?php echo esc_html( $hotline ); ?></span>
				</a>
			</div>
			<?php endif; ?>
		</div>
	<?php
	}

	/**
	 * Renders the action for a form.
	 *
	 * @since 1.0.0
	 * @param string $type The type of form being rendered.
	 * @return void
	 */
	public function form_action( $type = '' ) {
		return admin_url( '/admin.php?page=hotline-phone-ring' . $type );
	}

	/**
	 * Returns an option from the database for
	 * the admin settings page.
	 *
	 * @since 1.0.0
	 * @param string $key The option key.
	 * @return mixed
	 */
	public function option( $key, $network_override = true ) {
		if ( is_network_admin() ) {
			$value = get_site_option( $key );
		}
			elseif ( ! $network_override && is_multisite() ) {
				$value = get_site_option( $key );
			}
			elseif ( $network_override && is_multisite() ) {
				$value = get_option( $key );
				$value = ( false === $value || ( is_array( $value ) && in_array( 'disabled', $value ) ) ) ? get_site_option( $key ) : $value;
			}
			else {
			$value = get_option( $key );
		}

		return $value;
	}

	/**
	 * Saves settings.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function save() {
		if ( ! isset( $_POST['hpr-settings-nonce'] ) || ! wp_verify_nonce( $_POST['hpr-settings-nonce'], 'hpr-settings' ) ) {
			return;
		}

		$data = $this->data();

		$data['phone']          = isset( $_POST['hpr_options']['phone'] ) ? sanitize_text_field( $_POST['hpr_options']['phone'] ) : '';
		$data['style']          = isset( $_POST['hpr_options']['style'] ) ? sanitize_text_field( $_POST['hpr_options']['style'] ) : 'style1';
		$data['color']          = isset( $_POST['hpr_options']['color'] ) ? sanitize_text_field( $_POST['hpr_options']['color'] ) : '';
		$data['hotline_bar']    = isset( $_POST['hpr_options']['hotline_bar'] ) ? 'on' : 'off';
		$data['space_vertical'] = isset( $_POST['hpr_options']['space_vertical'] ) ? $_POST['hpr_options']['space_vertical'] : '';
		$data['space_horizon']  = isset( $_POST['hpr_options']['space_horizon'] ) ? $_POST['hpr_options']['space_horizon'] : '';
		$data['position']       = isset( $_POST['hpr_options']['position'] ) ? $_POST['hpr_options']['position'] : '';

		update_site_option( 'hpr_options', $data );
	}

	/**
	 * Admin footer text.
	 *
	 * Modifies the "Thank you" text displayed in the admin footer.
	 *
	 * Fired by `admin_footer_text` filter.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $footer_text The content that will be printed.
	 *
	 * @return string The content that will be printed.
	 */
	public function admin_footer_text( $footer_text ) {
		$current_screen = get_current_screen();
		$is_screen = ( $current_screen && false !== strpos( $current_screen->id, 'hotline-phone-ring' ) );

		if ( $is_screen ) {
			$footer_text = __( ' Enjoyed <strong>Hotline Phone Ring</strong>? Please leave us a <a href="https://namncn.com/plugins/hotline-phone-ring/" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. We really appreciate your support!', 'hotline-phone-ring' );
		}

		return $footer_text;
	}

	/**
	 * Frontend custom style.
	 */
	public function frontend_custom_style() {
		$data = $this->data();

		if ( $data['color'] ) :
			?>
			<style>
				.hotline-phone-ring-circle {
					border-color: <?php echo $data['color'] ?>;
				}
				.hotline-phone-ring-circle-fill, .hotline-phone-ring-img-circle, .hotline-bar {
					background-color: <?php echo $data['color'] ?>;
				}
			</style>

			<?php
			if ( 'style1' == $data['style'] ) :
				$hex = $data['color'];
				( strlen( $hex ) === 4 ) ? list( $r, $g, $b ) = sscanf( $hex, '#%1x%1x%1x' ) : list( $r, $g, $b ) = sscanf( $hex, '#%2x%2x%2x' );
				$hotlinebar_bg = "rgb( $r, $g, $b, .7 )";
				?>
				<style>
					.hotline-bar {
						background: <?php echo $hotlinebar_bg; ?>;
					}
				</style>
				<?php
			endif;
		endif;

		if ( 'right' == $data['position'] ) :
			?>
			<style>
				.hotline-phone-ring-wrap {
					left: auto;
					<?php echo $data['space_horizon'] ? ' right: ' . 'calc( 100px + ' . $data['space_horizon'] . ' );' : ''; ?>
					<?php echo $data['space_vertical'] ? ' bottom: ' . $data['space_vertical'] . ';' : ''; ?>
				}
			</style>
			<?php
		else :
			if ( $data['space_horizon'] && $data['space_vertical'] ) :
				?>
				<style>
					.hotline-phone-ring-wrap {
						<?php echo $data['space_horizon'] ? ' left: ' . $data['space_horizon'] . ';' : ''; ?>
						<?php echo $data['space_vertical'] ? ' bottom: ' . $data['space_vertical'] . ';' : ''; ?>
					}
				</style>
				<?php
			endif;
		endif;
	}

	/**
	 * [add_action_links description]
	 * @param  [type] $links_array [description]
	 * @return [type]              [description]
	 */
	public function add_action_links( $links ) {
		$links[] = '<a href="' . admin_url( '/admin.php?page=hotline-phone-ring' ) . '">' . esc_html__( 'Settings', 'hotline-phone-ring' ) . '</a>';

		return array_merge( $links );
	}

	/**
	 * [add_row_meta description]
	 * @param  [type] $links            [description]
	 * @param  [type] $plugin_file_name [description]
	 * @param  [type] $plugin_data      [description]
	 * @param  [type] $status           [description]
	 * @return [type]                   [description]
	 */
	public function add_row_meta( $links, $plugin_file_name, $plugin_data, $status ) {

		if ( strpos( $plugin_file_name, HPR_NAME ) ) {
			$links[] = '<a href="https://namncn.com/plugins/hotline-phone-ring/" target="_blank">' . esc_html__( 'FAQ', 'hotline-phone-ring' ) . '</a>';
			$links[] = '<a href="https://namncn.com/lien-he/" target="_blank">' . esc_html__( 'Support', 'hotline-phone-ring' ) . '</a>';
			$links[] = '<a href="https://namncn.com/chuyen-muc/plugins/" target="_blank">' . esc_html__( 'Other Plugins', 'hotline-phone-ring' ) . '</a>';
		}

		return $links;
	}
}
