<?php
/**
 * REST API Controller Base.
 *
 * @since 1.0.0
 *
 * @package WC_Themes
 * @category Products
 * @author Astoundify
 */

namespace Astoundify\WC_Themes\API;
use WC_REST_Controller, WP_REST_Server, WP_Error;

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
	protected $namespace = 'astoundify/wc-themes/v1';
}
