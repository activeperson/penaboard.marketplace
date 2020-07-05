<?php
/**
 * Include Composer's autoloader.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Bootstrap
 * @author Astoundify
 */

$file = __DIR__ . '/../vendor/autoload.php';

if ( file_exists( $file ) ) {
	require( $file );
}
