<?php

/**
 * Support Webp
 *
 * @package           support-webp
 * @author            Sayedul Sayem
 * @copyright         2021 - 2024 Sayedulsayem
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Support WebP
 * Plugin URI:        https://wordpress.org/plugins/support-webp/
 * Description:       This plugin will allow you to upload webp format image on WordPress media
 * Version:           1.0.1
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            Sayedul Sayem
 * Author URI:        https://sayedulsayem.com
 * Text Domain:       support-webp
 * Domain Path:       /i18n/
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
namespace SayedulSayem\SupportWebp;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( SupportWebp::class ) && is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	/** @noinspection PhpIncludeInspection */
	require_once __DIR__ . '/vendor/autoload.php';
}

class_exists( SupportWebp::class ) && SupportWebp::instance()->init();
