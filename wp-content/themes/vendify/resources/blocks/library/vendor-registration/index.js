/**
 * WordPress dependencies.
 *
 * @var vendifyEditorSettings
 */
const { __ } = wp.i18n;
const { ServerSideRender } = wp.components;
const { registerBlockType } = wp.blocks;

const blockName = 'vendify/vendor-registration';

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
	registerBlockType( blockName, {
		title: __( 'Vendor Registration Form' ),
		description: __( 'Add a form for guests to register to become a vendor.' ),
		icon: 'feedback',
		category: 'vendify',
		keywords: [
			__( 'vendor' ),
			__( 'register' ),
		],
		attributes: {},

		/**
		 * Edit mode.
		 *
		 * @param {Object} props Block properties.
		 * @return {string} Block HTML.
		 */
		edit( props ) {
			return <div className="block-with-disabled-style">
				<ServerSideRender block={ blockName } attributes={ props.attributes } />
			</div>;
		},

		/**
		 * Save mode.
		 *
		 * @return {null} Nothing.
		 */
		save() {
			return null;
		},
	} );

}
