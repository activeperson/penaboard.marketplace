/**
 * External dependencies.
 */
import { get, times, pick, map, forEach } from 'lodash';
import classnames from 'classnames';

/**
 * WordPress dependencies.
 */
const { __, sprintf } = wp.i18n;
const { getBlobByURL } = wp.blob;
const { Component, Fragment } = wp.element;
const { RichText, MediaUpload, InspectorControls, BlockControls, BlockAlignmentToolbar } = wp.blockEditor;
const { editorMediaUpload } = wp.editor;
const { withNotices, PanelBody, RangeControl, SelectControl, IconButton } = wp.components;

/**
 * Internal dependencies.
 */
import { updateDeep } from './../../utils';
import { validAlignments } from './index.js';

const iconAlignmentOptions = [
	{
		value: 'left',
		label: __( 'Left' ),
	},
	{
		value: 'top',
		label: __( 'Top' ),
	},
	{
		value: 'right',
		label: __( 'Right' ),
	},
];

/**
 * Edit a list of features.
 */
class FeaturesEdit extends Component {
	constructor() {
		super( ...arguments );

		this.updateFeature = this.updateFeature.bind( this );
		this.onSelectImage = this.onSelectImage.bind( this );
	}

	/**
	 * Get the image's IDs from the URL so they can be preselected when editing.
	 */
	componentDidMount() {
		const { attributes } = this.props;
		const { features, columns } = attributes;

		times( columns, ( index ) => {
			const { id, url = '' } = features[ index ];

			if ( ! id && url.indexOf( 'blob:' ) === 0 ) {
				const file = getBlobByURL( url );

				if ( file ) {
					editorMediaUpload( {
						filesList: [ file ],
						onFileChange: ( [ image ] ) => {
							this.updateFeature( index, pick( image, [ 'id', 'url' ] ) );
						},
						allowedType: 'image',
					} );
				}
			}
		} );
	}

	/**
	 * Helper to update an individual feature's image.
	 *
	 * @param {number} index Feature index to update.
	 * @param {Object} media WordPress media object.
	 */
	onSelectImage( index, media ) {
		if ( ! media ) {
			return;
		}

		const vars = pick( media, [ 'id', 'url' ] );

		forEach( vars, ( value, key ) => {
			this.updateFeature( index, {
				[ key ]: value,
			} );
		} );
	}

	/**
	 * Helper to update an individual feature.
	 *
	 * @param {number} index Feature index to update.
	 * @param {Object} update Object properties to update.
	 */
	updateFeature( index, update ) {
		const {
			attributes,
			setAttributes,
		} = this.props;

		setAttributes( {
			features: updateDeep( attributes.features, index, update ),
		} );
	}

	/**
	 * Render Block.
	 *
	 * @return {string} Block editing.
	 */
	render() {
		const { attributes, setAttributes, className, noticeUI, isSelected } = this.props;
		const { features, columns, iconAlign, align } = attributes;

		const classNames = classnames(
			'feature-block',
			'alignfull',
			{
				[ className ]: true,
				[ `feature-block--${ iconAlign }-aligned` ]: true,
				[ `columns-${ columns }` ]: true,
			}
		);

		const isTop = 'top' === iconAlign;

		return (
			<Fragment>
				{ noticeUI }

				<BlockControls>
					<BlockAlignmentToolbar
						value={ align }
						onChange={ ( value ) => setAttributes( { align: value } ) }
						controls={ validAlignments }
					/>
				</BlockControls>

				<InspectorControls>
					<PanelBody>
						<RangeControl
							label={ __( 'Number of Features' ) }
							value={ columns }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
							min={ 1 }
							max={ 3 }
						/>

						<SelectControl
							label={ __( 'Icon Alignment' ) }
							value={ iconAlign }
							options={ map( iconAlignmentOptions, ( data ) => ( { ...data } ) ) }
							onChange={ ( value ) => setAttributes( { iconAlign: value } ) }
						/>
					</PanelBody>
				</InspectorControls>

				<div className={ classNames }>
					<div className="feature-block__cols">
						{ times( columns, ( index ) => {
							const { title, description, id, url } = get( features, [ index ] ) || {};

							return (
								<div className={ `feature-block__col ${ ! isTop ? 'media' : null }` } key={ index }>
									<MediaUpload
										gallery={ false }
										multiple={ false }
										onSelect={ ( media ) => this.onSelectImage( index, media ) }
										type="image"
										value={ id }
										render={ ( { open } ) => (
											<div className="feature-block__col-image">
												{ isSelected && (
													<IconButton className="edit-image" icon="format-image" onClick={ open } />
												) }

												{ url && (
													<img src={ url } alt="" />
												) }
											</div>
										) }
									/>

									<div className="media-body">

										<h3 className="feature-block__col-title">
											<RichText
												value={ title }
												multitline={ false }
												onChange={ ( value ) => this.updateFeature( index, { title: value } ) }
												placeholder={ `Feature ${ index + 1 }` }
											/>
										</h3>

										<div className="feature-block__col-description">
											<RichText
												tagName="p"
												value={ description }
												multitline
												onChange={ ( value ) => this.updateFeature( index, { description: value } ) }
												placeholder={ sprintf( __( 'Feature %s description...' ), index + 1 ) }
											/>
										</div>

									</div>
								</div>
							);
						} ) }
					</div>
				</div>
			</Fragment>
		);
	}
}

export default withNotices( FeaturesEdit );
