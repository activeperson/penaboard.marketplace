<?php
/**
 * View Single Note Order
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @var object $note
 *
 * @package WC_Themes
 * @category Template
 * @author Astoundify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<li class="order-update">
	<div class="order-update__content">
		<header class="order-update__header">
			<span class="order-update__date"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $note->date_created->getTimestamp() ) ); ?></span>
		</header>

		<div class="order-update__body">
			<?php echo wpautop( wptexturize( $note->content ) ); ?>
		</div>
	</div>
</li>
