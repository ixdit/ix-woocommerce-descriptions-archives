<?php

namespace IXWDA;

class Requirements {

	/**
	 * @var array[]
	 */
	private array $required_plugins;

	public function __construct() {

		$this->required_plugins = [
			[
				'plugin'  => 'woocommerce/woocommerce.php',
				'name'    => 'WooCommerce',
				'slug'    => 'woocommerce',
				'class'   => 'WooCommerce',
				'version' => '3.0',
				'active'  => false,
			],
		];

	}

	public function init() {

		add_action( 'admin_init', [ $this, 'check_requirements' ] );

		foreach ( $this->required_plugins as $required_plugin ) {
			if ( ! class_exists( $required_plugin['class'] ) ) {
				return;
			}
		}

	}

	public function check_requirements() {

		if ( false === $this->requirements() ) {
			$this->deactivation_plugin();
		}
	}

	private function requirements(): bool {

		$all_active = true;
		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		foreach ( $this->required_plugins as $key => $required_plugin ) {
			if ( is_plugin_active( $required_plugin['plugin'] ) ) {
				$this->required_plugins[ $key ]['active'] = true;
			} else {
				$all_active = false;
			}
		}

		return $all_active;
	}

	/**
	 * @return void
	 */
	private function deactivation_plugin() {
		add_action( 'admin_notices', [ $this, 'show_plugin_not_found_notice' ] );
		if ( is_plugin_active( IXWDA_PLUGIN_FILE ) ) {

			deactivate_plugins( IXWDA_PLUGIN_FILE );
			// @codingStandardsIgnoreStart
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			// @codingStandardsIgnoreEnd
			add_action( 'admin_notices', [ $this, 'show_deactivate_notice' ] );
		}
	}

	public function show_plugin_not_found_notice() {

		$message = sprintf(
		/* translators: 1: Name author plugin */
			__( 'The %s requires installed and activated plugins: ', 'ix-woocommerce-descriptions-archives' ),
			esc_attr( IXWDA_PLUGIN_NAME )
		);

		$message_parts = [];

		foreach ( $this->required_plugins as $key => $required_plugin ) {
			if ( ! $required_plugin['active'] ) {
				$href = '/wp-admin/plugin-install.php?tab=plugin-information&plugin=';

				$href .= sprintf( "%s&TB_iframe=true&width=640&height=500", $required_plugin['slug'] );

				$message_parts[] = sprintf( '<strong><em><a href="%s" class="thickbox">%s%s%s</a>%s</em></strong>',
					$href,
					$required_plugin['name'],
					__( ' version ', 'ix-woocommerce-descriptions-archives' ),
					$required_plugin['version'],
					__( ' or higher', 'ix-woocommerce-descriptions-archives' )
				);
			}
		}

		$count = count( $message_parts );
		foreach ( $message_parts as $key => $message_part ) {
			if ( 0 !== $key ) {
				if ( ( ( $count - 1 ) === $key ) ) {
					$message .= __( ' and ', 'ix-woocommerce-descriptions-archives' );
				} else {
					$message .= ', ';
				}
			}

			$message .= $message_part;
		}

		$message .= '.';

		$this->admin_notice( $message, 'notice notice-error is-dismissible' );
	}

	public function show_deactivate_notice() {

		$message = sprintf(
		/* translators: 1: Name author plugin */
			__( '%s plugin has been deactivated.', 'ix-woocommerce-descriptions-archives' ),
			esc_attr( IXWDA_PLUGIN_NAME )
		);

		$this->admin_notice( $message, 'notice notice-warning is-dismissible' );
	}

	private function admin_notice( $message, $class ) {

		?>
        <div class="<?php echo esc_attr( $class ); ?>">
            <p>
				<span>
				<?php echo wp_kses_post( $message ); ?>
				</span>
            </p>
        </div>
		<?php

	}


}