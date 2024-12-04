<?php
/**
 * Support Webp
 *
 * @package           support-webp
 * @author            Sayedul Sayem
 * @copyright         2021 Sayedulsayem
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Support WebP
 * Plugin URI:        https://wordpress.org/plugins/support-webp/
 * Description:       This plugin will allow you to upload webp format image on wordpress media
 * Version:           1.0.1
 * Requires at least: 4.7
 * Requires PHP:      5.6
 * Author:            Sayedul Sayem
 * Author URI:        https://sayedulsayem.com
 * Text Domain:       support-webp
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// run plugin initialization file
require 'plugin.php';

/**
 * update permalink after register cpt
 */
register_activation_hook( __FILE__, [ SupportWebp\Plugin::instance(), 'flush_rewrites'] );

/**
 * load plugin after initialize wordpress core
 */
add_action( 'plugins_loaded', function(){
    SupportWebp\Plugin::instance()->init();
});