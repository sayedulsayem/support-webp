<?php

namespace SayedulSayem\SupportWebp\Traits;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

/**
 * singleton purpose trait
 *
 *
 * @author sayedulsayem
 * @since 1.1.0
 */
trait Singleton {

	private static $instance;

	/**
	 * single instance create function
	 *
	 * @return object
	 * @since 1.1.0
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
