/**
 *
 * Hero Search bar.
 *
 */

const heroSearch = function() {
	if ( typeof Vendify.shopUrl === "undefined" || typeof Vendify.findVendorsUrl === "undefined" ) {
		return;
	}

	const form = document.querySelector( '.hero-search' );
	const { woocommerce: { shopUrl, findVendorsUrl } } = Vendify;

	if ( ! form || ! findVendorsUrl ) {
		return;
	}

	const switchToggle = document.querySelector( '.hero-search__switch .switch__input' );
	// const locationInput = document.querySelector( '.filter__location' );
	const keywordInput = document.querySelector( '.filter__search input' );

	switchToggle.addEventListener( 'change', ( e ) => {
		const isChecked = switchToggle.checked;

		// Show vendor location.
		// locationInput.style.display = isChecked ? 'flex' : 'none';

		// Update keyword field name.
		keywordInput.name = isChecked ? 'vendor_keyword' : 's';

		// Update form action.
		form.action = isChecked ? findVendorsUrl : shopUrl;
	} );
};

export default heroSearch();
