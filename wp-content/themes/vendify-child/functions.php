<?php
/**
 * Vendify child theme.
 *
 * Place any custom functionality/code snippets here.
 *
 * @since Vendify Child 1.0.0
 */
function vendify_child_styles() {
    wp_enqueue_style( 'vendify-child', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'vendify_child_styles', 20 );