<?php
/**
 * REST API Controller Base.
 *
 * @since 1.0.0
 *
 * @package Astoundify\WC_Product_Editor
 * @category Admin
 * @author Astoundify
 */

namespace Astoundify\WC_Product_Editor\API;

use WC_REST_Controller;

/**
 * Rest Controller Base
 *
 * @since 1.0.0
 *
 * @extends WC_REST_Controller
 */
class REST_Controller extends WC_REST_Controller {

	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'astoundify/wc-product-editor/v1';

}
