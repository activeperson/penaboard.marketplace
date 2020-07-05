const notices = function() {
	const $notices = $( '.woocommerce-info' );
	const $el = $notices.detach();

	$( '.main-content' ).prepend( $el );
};

export default notices();
