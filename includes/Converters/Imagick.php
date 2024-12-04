<?php

namespace SayedulSayem\SupportWebp\Converters;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

class Imagick {
	use \SayedulSayem\SupportWebp\Traits\Singleton;

	public function convertToWebp( $source_path, $output_path, $quality = 80 ) {
		try {
			$image = new \Imagick( $source_path );

			$image->setImageFormat( 'webp' );
			$image->setCompressionQuality( $quality );

			$image->writeImage( $output_path );

			$image->clear();
			$image->destroy();

			return $output_path;

		} catch ( \Exception $e ) {
			echo 'Error: ' . $e->getMessage() . "\n";

			return false;
		}

		return false;
	}
}
