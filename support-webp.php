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
 * Plugin Name:       Support Webp
 * Plugin URI:        https://sayedulsayem.com/
 * Description:       This plugin will allow you to upload webp format image on wordpress media
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            sayedulsayem
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