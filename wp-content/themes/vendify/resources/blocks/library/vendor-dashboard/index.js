/**
 * WordPress dependencies.
 *
 * @var vendifyEditorSettings
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { ServerSideRender, Placeholder } = wp.components;

if ( vendifyEditorSettings.hasVendorIntegration === "1" ) {

	/**
	 * Register "Vendor Registration" block.
	 *
	 * @since 1.0.0
	 *
	 * @param  {string}   name     Block name.
	 * @param  {Object}   settings Block settings.
	 * @return {?WPBlock}          The block, if it has been successfully
	 *                             registered; otherwise `undefined`.
	 */
	registerBlockType( 'vendify/vendor-dashboard', {
		title: __( 'Vendor Dashboard' ),
		description: __( 'Add the Vendor dashboard. This block works only with the selected Vendor Dashboard page.' ),
		icon: 'feedback',
		category: 'vendify',
		keywords: [
			__( 'vendor' ),
			__( 'dashboard' ),
		],
		supports: {
			multiple: false,
			reusable: false,
			inserter: vendifyEditorSettings.isVendorDashboard === "1" || false,
		},
		attributes: {},

		/**
		 * Edit mode.
		 *
		 * @param {Object} props Block properties.
		 * @return {string} Block HTML.
		 */
		edit( props ) {
			return <Placeholder
				label={__( 'Vendor Dashboard' ) }
				icon="feedback"
			>
				<p>{__( 'This block will output the Vendor Dashboard, which is too large to fit here, the editor side.' )}</p>
			</Placeholder>;
		},

		/**
		 * Save mode.
		 *
		 * @return {null} Nothing.
		 */
		save() {
			return null;
		},
	});

}
