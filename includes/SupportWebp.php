<?php

namespace SayedulSayem\SupportWebp;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

class SupportWebp {
	use \SayedulSayem\SupportWebp\Traits\Singleton;

	public function init() {
		$this->define_constants();

		register_activation_hook( \plugin_dir_path( __DIR__ ) . 'support-webp.php', [ $this, 'activate' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * defining constant function
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function define_constants() {
		define( 'SUPPORT_WEBP_VERSION', '1.0.1' );
		define( 'SUPPORT_WEBP_PACKAGE', 'free' );
		define( 'SUPPORT_WEBP_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'SUPPORT_WEBP_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
	}

	public function activate() {
		flush_rewrite_rules();
	}

	public function init_plugin() {
		add_filter( 'mime_types', [ $this, 'webp_modify_mimes' ] );

		add_filter( 'upload_mimes', [ $this, 'webp_modify_mimes' ], 1, 1 );

		add_filter( 'file_is_displayable_image', [ $this, 'webp_is_displayable' ], 10, 2 );

		// call converter
		Converters\Base::instance()->init();
	}

	public function webp_modify_mimes( $existing_mimes ) {
		$existing_mimes['webp'] = 'image/webp';

		return $existing_mimes;
	}

	public function webp_is_displayable( $result, $path ) {
		if ( false === $result ) {
			$displayable_image_types = [ IMAGETYPE_WEBP ];
			$info                    = @getimagesize( $path );

			if ( empty( $info ) ) {
				$result = false;
			} elseif ( ! in_array( $info[2], $displayable_image_types ) ) {
				$result = false;
			} else {
				$result = true;
			}
		}

		return $result;
	}
}
