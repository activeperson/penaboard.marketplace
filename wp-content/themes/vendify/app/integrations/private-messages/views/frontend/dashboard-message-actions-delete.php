<?php
/**
 * Dashboard - Message Actions: Delete
 *
 * Display the delete reply link.
 * it will not actually delete the replies, only hiding/archive it from user view.
 *
 * @since 1.4.0
 */

namespace Astoundify\Vendify;

?>
<a href="<?php echo esc_url( $message->delete_url() ); ?>">
	<?php
	svg(
		[
			'icon'    => 'delete',
			'classes' => [ 'ico--sm' ],
		]
); ?>
</a>
