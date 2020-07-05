<?php
/**
 * Plain link menu walker.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Menu
 * @author Astoundify
 */

namespace Astoundify\Vendify;

use Walker;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Walk a menu to just output plain anchors.
 *
 * @since 1.0.0
 */
class Link_Menu_Walker extends Walker {

	/**
	 * Link class.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $class;

	/**
	 * Class(es) to apply to anchors.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class Class to apply to link item.
	 */
	public function __construct( $class = 'link' ) {
		$this->class = $class;
	}

	/**
	 * Walk the whole menu.
	 *
	 * @since 1.0.0
	 *
	 * @param array $items Elements to walk.
	 * @param int   $max_depth Maximum depth.
	 * @return string
	 */
	public function walk( $items, $max_depth ) {
		$list  = [];
		$items = array_map( 'wp_setup_nav_menu_item', $items );

		foreach ( $items as $item ) {
			$list[] = sprintf( '<a href="%s" class="%s">%s</a>', esc_url( $item->url ), esc_attr( $this->class ), esc_attr( $item->title ) );
		}

		return implode( '', $list );
	}

}
