<?php

namespace SupportWebp;

defined('ABSPATH') || exit;

/**
 * main plugin loaded final class
 *
 * @author sayedulsayem 
 * @since 1.0.0
 */
final class Plugin
{

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
    public function __construct()
    {
        $this->define_constant();
    }

    /**
     * defining constant function
     *
     * @return void
     * @since 1.0.0
     */
    public function define_constant()
    {

        define('SUPPORT_WEBP_VERSION', '1.0.0');
        define('SUPPORT_WEBP_PACKAGE', 'free');
        define('SUPPORT_WEBP_PLUGIN_URL', trailingslashit(plugin_dir_url(__FILE__)));
        define('SUPPORT_WEBP_PLUGIN_DIR', trailingslashit(plugin_dir_path(__FILE__)));
    }

    /**
     * plugin initialization function
     *
     * @return void
     * @since 1.0.0
     */
    public function init()
    {
        add_filter('mime_types', [$this, 'webp_upload_mimes']);

        add_filter('upload_mimes', [$this, 'webp_mimes_add'], 1, 1);

        add_filter('file_is_displayable_image', [$this, 'webp_is_displayable'], 10, 2);
    }

    public function webp_mimes_add($mime_types)
    {
        $mime_types['webp'] = 'image/webp';
        return $mime_types;
    }


    public function webp_upload_mimes($existing_mimes)
    {
        $existing_mimes['webp'] = 'image/webp';
        return $existing_mimes;
    }


    public function webp_is_displayable($result, $path)
    {
        if ($result === false) {
            $displayable_image_types = array(IMAGETYPE_WEBP);
            $info = @getimagesize($path);

            if (empty($info)) {
                $result = false;
            } elseif (!in_array($info[2], $displayable_image_types)) {
                $result = false;
            } else {
                $result = true;
            }
        }

        return $result;
    }

    public function flush_rewrites()
    {
        flush_rewrite_rules();
    }

    /**
     * singleton instance create function
     *
     * @return object
     * @since 1.0.0
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
