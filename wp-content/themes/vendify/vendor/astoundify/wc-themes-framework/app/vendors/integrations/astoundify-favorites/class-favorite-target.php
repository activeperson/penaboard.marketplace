<?php
/**
 * Vendor as Favorite Target.
 *
 * @since 1.0.0
 *
 * @package Vendors
 * @category Core
 * @author Astoundify
 */

namespace Astoundify\WC_Themes\Vendors;

/**
 * A single favorite target item.
 *
 * @since 1.0.0
 */
class Favorite_Target extends \Astoundify\Favorites\Favorite_Target {

	/**
	 * Target type. In this case taxonomy.
	 *
	 * @var object
	 * @since 1.0.0
	 */
	public $type = 'wcpv_product_vendors';

	/**
	 * Constructor
	 *
	 * @since 1.3.0
	 *
	 * @param object|int|false $target Target object.
	 */
	public function __construct( $target = null ) {
		// Bail if false.
		if ( false === $target ) {
			return;
		}

		// Is a post object/ID, use it.
		if ( is_a( $target, 'WP_Term' ) ) {
			$this->target = $target;
		} elseif ( is_numeric( $target ) ) {
			$this->target = get_term( $target, $this->type );
		}

		// Bail if we can't find a WordPress object to use.
		if ( ! $this->target ) {
			return;
		}
	}

	/**
	 * Get ID.
	 *
	 * @since 1.3.0
	 *
	 * @return int
	 */
	public function get_id() {
		if ( ! $this->get_object() ) {
			return 0;
		}

		return absint( $this->get_object()->term_id );
	}

	/**
	 * Get title
	 *
	 * @since 1.3.0
	 *
	 * @return string
	 */
	public function get_title() {
		if ( ! $this->get_object() ) {
			return '';
		}

		$title = $this->get_object()->name;
		return $title ? $title : esc_html__( 'N/A', 'astoundify-wc-themes' );
	}

	/**
	 * Get permalink
	 *
	 * @since 1.3.0
	 *
	 * @return string
	 */
	public function get_link() {
		if ( ! $this->get_object() ) {
			return '';
		}

		$title = $this->get_title();

		$el   = 'a';
		$attr = array(
			'class' => 'astoundify-favorites-target-link',
			'href'  => get_term_link( $this->get_object() ),
		);

		$attr_str = astoundify_favorites_attr( $attr );

		$link = "<{$el} {$attr_str}>{$title}</{$el}>";

		return apply_filters( 'astoundify_favorites_get_target_link', $link, $this->get_object() );
	}

	/**
	 * Get count (cache)
	 *
	 * @since 1.3.0
	 *
	 * @param bool $recalculate Force recalculate. Default to false.
	 * @return string
	 */
	public function get_count( $recalculate = false ) {
		if ( ! $this->get_object() ) {
			return 0;
		}

		$count = absint( get_term_meta( $this->get_id(), '_astoundify_favorites_count', true ) );

		if ( ! $count || $recalculate ) {
			$count = $this->update_count();
		}

		return absint( $count );
	}

	/**
	 * Update count
	 *
	 * @since 1.3.0
	 *
	 * @return int|false
	 */
	public function update_count() {
		$args = array(
			'target_id'      => $this->get_id(),
			'target_type'    => $this->get_type(),
			'fields'         => 'ids',
			'item_per_page'  => -1,
			'user_id'        => false,
		);

		$favorite_query = new \Astoundify\Favorites\Favorite_Query( $args );
		$count = $favorite_query->total_items;

		update_term_meta( $this->get_id(), '_astoundify_favorites_count', absint( $count ) );

		return absint( $count );
	}

	/**
	 * Reset Count
	 *
	 * @since 1.3.0
	 *
	 * @return bool
	 */
	public function reset_count() {
		if ( ! $this->get_object() ) {
			return false;
		}

		return delete_term_meta( $this->get_id(), '_astoundify_favorites_count' );
	}
}
