<?php
/**
 * Include Composer's autoloader.
 *
 * @since 1.0.0
 *
 * @package Vendify
 * @category Bootstrap
 * @author Astoundify
 */

$file = get_parent_theme_file_path( 'vendor/autoload.php' );

if ( file_exists( $file ) ) {
	require $file;
}
