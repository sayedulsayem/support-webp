<?php

namespace SayedulSayem\SupportWebp\Converters;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

class GD {
	use \SayedulSayem\SupportWebp\Traits\Singleton;

	public function convertToWebp( $source_path, $output_path, $quality = 80 ) {
		// Check the image type
		$info = getimagesize( $source_path );
		$mime = $info['mime'];

		// Create an image resource from the source file
		switch ( $mime ) {
			case 'image/jpeg':
				$image = imagecreatefromjpeg( $source_path );
				break;
			case 'image/png':
				$image = imagecreatefrompng( $source_path );
				// Remove alpha channel for WebP
				imagepalettetotruecolor( $image );
				imagealphablending( $image, true );
				imagesavealpha( $image, true );
				break;
			case 'image/gif':
				$image = imagecreatefromgif( $source_path );
				break;
			default:
				die( 'Unsupported image type: ' . $mime );
		}

		// Save the image as WebP
		if ( ! imagewebp( $image, $output_path, $quality ) ) {
			echo "Failed to convert image to WebP.\n";

			return false;
		}

		// Free memory
		imagedestroy( $image );

		return $output_path;
	}
}
