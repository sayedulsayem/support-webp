<?php

namespace SayedulSayem\SupportWebp\Converters;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

class Base {
	use \SayedulSayem\SupportWebp\Traits\Singleton;

	private $converter   = null;
	private $webp_images = [];

	public function __construct() {
		if ( extension_loaded( 'imagick' ) ) {
			$this->converter = Imagick::instance();
		} else if ( extension_loaded( 'gd' ) ) {
			$this->converter = GD::instance();
		} else {
			add_action( 'admin_notices', [$this, 'extension_missing_notice'] );
		}
	}

	public function init() {
		if ( 'GET' === $_SERVER['REQUEST_METHOD'] && isset( $_GET['convert'] ) && 'webp' === $_GET['convert'] ) {
			$images            = $this->get_last_10_images();
			$this->webp_images = [];
			foreach ( $images as $image ) {
				$id          = $image->ID;
				$source_path = get_attached_file( $id );
				$ext         = pathinfo( $source_path, PATHINFO_EXTENSION );
				$output_path = str_replace( $ext, 'webp', $source_path );

				$webp_image_path = $this->converter->convertToWebp( $source_path, $output_path );
				if ( $webp_image_path ) {
					$this->webp_images[] = ['parent_id' => $id, 'webp_path' => $webp_image_path];
				}
			}
			wp_reset_postdata();
			$this->upload_image_to_media();
		}
	}

	public function get_last_10_images() {
		$args = [
			'post_type'      => 'attachment',
			'post_mime_type' => ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff'],
			'posts_per_page' => 10,
			'order'          => 'ASC',
			'orderby'        => 'date'
		];

		$images = get_posts( $args );

		return $images;
	}

	public function upload_image_to_media() {
		foreach ( $this->webp_images as $webp_image ) {

			$webp_image_path = $webp_image['webp_path'];
			$parent_id       = $webp_image['parent_id'];

			$filetype = wp_check_filetype( basename( $webp_image_path ), null );

			$wp_upload_dir = wp_upload_dir();

			$attachment = [
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $webp_image_path ),
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '-webp', basename( $webp_image_path ) ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			];

			$attach_id = wp_insert_attachment( $attachment, $webp_image_path, $parent_id );

			require_once ABSPATH . 'wp-admin/includes/image.php';

			$attach_data = wp_generate_attachment_metadata( $attach_id, $webp_image_path );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			set_post_thumbnail( $parent_id, $attach_id );
		}
	}

	public function extension_missing_notice() {
		echo '<div class="error"><p>' . esc_html__( 'The image converter plugin requires
		<code>imagick</code> or <code>gd</code> extension to
		function properly. Please install one of them.', 'image_converter' ) . '</p></div
		>';
	}
}
