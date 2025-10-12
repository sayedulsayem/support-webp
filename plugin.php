<?php

namespace SupportWebp;

defined( 'ABSPATH' ) || exit;

/**
 * main plugin loaded final class
 *
 * @author sayedulsayem
 * @since 1.0.0
 */
final class Plugin {

	/**
	 * accesing for object of this class
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * construct function of this class
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->define_constant();
	}

	/**
	 * defining constant function
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function define_constant() {

		define( 'SUPPORT_WEBP_VERSION', '1.0.1' );
		define( 'SUPPORT_WEBP_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'SUPPORT_WEBP_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
	}

	/**
	 * plugin initialization function
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function init() {
		load_plugin_textdomain( 'support-webp', false, SUPPORT_WEBP_PLUGIN_DIR . 'i18n/' );

		add_filter( 'mime_types', [$this, 'webp_modify_mimes'] );

		add_filter( 'upload_mimes', [$this, 'webp_modify_mimes'], 1, 1 );

		add_filter( 'file_is_displayable_image', [$this, 'webp_is_displayable'], 10, 2 );
	}

	public function webp_modify_mimes( $existing_mimes ) {
		$existing_mimes['webp'] = 'image/webp';

		return $existing_mimes;
	}

	public function webp_is_displayable( $result, $path ) {
		if ( false === $result ) {
			$displayable_image_types = [IMAGETYPE_WEBP];
			$info                    = @getimagesize( $path );

			if ( empty( $info ) ) {
				$result = false;
			} else if ( ! in_array( $info[2], $displayable_image_types ) ) {
				$result = false;
			} else {
				$result = true;
			}
		}

		return $result;
	}

	public function flush_rewrites() {
		flush_rewrite_rules();
	}

	/**
	 * singleton instance create function
	 *
	 * @return object
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
