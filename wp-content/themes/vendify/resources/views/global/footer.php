<?php
/**
 * Global page footer.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package Vendify
 * @category Template
 * @author Astoundify
 */

namespace Astoundify\Vendify;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>
					<footer class="site-footer">
						<div class="container">
							<?php
							partial( 'footer/widgets' );
							partial( 'footer/copyright' ); ?>
						</div>
					</footer>
				</div>
			</div>
		</div>

		<?php wp_footer(); ?>

	</body>
</html>
