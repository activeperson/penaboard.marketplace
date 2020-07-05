<?php
/**
 * Messages - User Info
 *
 * @since 1.0.0
 * @version 1.8.0
 */

namespace Astoundify\Vendify;

if ( $thread->is_unread() ) :
	svg(
		[
			'icon'    => 'unread',
			'classes' => [ 'msg-preview__icon', 'ico--xs' ],
		]
	);
else :
	svg(
		[
			'icon'    => 'replied',
			'classes' => [ 'msg-preview__icon', 'ico--xs' ],
		]
	);
endif;

if ( get_option( 'show_avatars', true ) ) : ?>
	<span class="msg-preview__img">

	<?php
	printf(
		'<a href="%s#message-%s">%s</a>',
		esc_url( $thread->get_url() ),
		isset( $last_message ) ? esc_attr( $last_message->ID ) : 'none',
		pm_get_avatar( $recipient->ID )
	); ?>
	</span>
<?php endif; ?>
