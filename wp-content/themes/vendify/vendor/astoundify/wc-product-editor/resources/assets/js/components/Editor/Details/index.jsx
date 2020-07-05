/**
 * External dependencies.
 */
import React from 'react';
import { connect } from 'react-redux';
import propTypes from 'prop-types';

_.contains = _.includes;

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

/**
 * Internal dependencies.
 */
import postShape from 'shapes/post';
import loadingShape from 'shapes/loading';
import { arrayOfCategories } from 'shapes/category';
import { arrayOfTags } from 'shapes/tag';
import { updatePost } from 'redux/state/post';
import { createCategory } from 'redux/state/categories';
import { createTag } from 'redux/state/tags';
import { reloadFrame, runOnFrame, frameReady } from 'redux/state/preview';
import { replacePrice } from 'utils/price';
import { productType, getWeightUnit, getDimensionsUnit } from 'utils/product';
import Tab from 'components/Editor/Tab';
import Checkbox from 'elements/Checkbox';
import Text from 'elements/TextInput';
import Select from 'elements/Select';
import MultiSelect from 'elements/MultiSelect';
import TextArea from 'elements/EditorTextArea';
import FileUpload from '../../../elements/FileUpload';

class Details extends React.Component {
	static propTypes = {
		post: postShape.isRequired,
		updatePost: propTypes.func.isRequired,
		categories: arrayOfCategories.isRequired,
		tags: arrayOfTags.isRequired,
		runOnFrame: propTypes.func.isRequired,
		reloadFrame: propTypes.func.isRequired,
		frameReady: propTypes.func.isRequired,
		elements: propTypes.shape().isRequired,
	};

	updateFrameText = ( event, selector ) => {
		let val = '';

		if ( ! event.target ) {
			val = event;
		} else {
			val = event.target.value;
		}

		const update = ( { document: frame } ) => {
			frame.querySelector( selector ).innerHTML = val;
		};

		this.props.runOnFrame( update );
	};

	handleSave = ( event ) => {
		const {
			target: { name, value },
		} = event;
		const { post } = this.props;
		if ( name.indexOf( '.' ) === -1 ) {
			if ( value !== post[ name ] ) {
				this.props.updatePost( post.id, { [ name ]: value } );
			} else {
				this.props.frameReady();
			}
		} else {
			const [ object, property ] = name.split( '.' );
			if ( value !== post[ object ][ property ] ) {
				this.props.updatePost( post.id, {
					[ object ]: { [ property ]: value },
				} );
			} else {
				this.props.frameReady();
			}
		}
	};

	handleCheckSave = ( event ) => {
		const {
			post: { id: postId, ...post },
		} = this.props;
		const {
			target: { name, checked },
		} = event;
		if ( checked !== post[ name ] ) {
			this.props.updatePost( postId, { [ name ]: checked } );
		}
	};

	/**
	 * For now we save only the `downloads` key.
	 * @TODO make this field take a dynamic key.
	 *
	 * @param newVal
	 */
	handleFileUploadSave = ( newVal ) => {
		const { post } = this.props;

		this.props.updatePost( post.id, {
			downloads: newVal,
		} );

	};

	saveAndReload = ( event ) => {
		const { type } = event.target;
		this.props.reloadFrame();
		if ( type === 'checkbox' ) {
			this.handleCheckSave( event );
		} else {
			this.handleSave( event );
		}
	};

	updatePrice = ( { target: { name, value } } ) => {
		const {
			post : { id },
			elements,
		} = this.props;
		const update = ( { document: frame } ) => {
			const selector = elements.regular_price.element;
			const [ regular, sale ] = frame.querySelectorAll( selector );
			if ( name === 'sale_price' ) {
				if ( ! sale || value === '' ) {
					this.props.reloadFrame();
					this.props.updatePost( id, { [ name ]: value } );
				} else {
					sale.innerHTML = replacePrice( sale.innerHTML, value );
				}
			} else if ( name === 'regular_price' ) {
				regular.innerHTML = replacePrice( regular.innerHTML, value );
			}
		};

		this.props.runOnFrame( update );
	};

	handleMultiSave = ( name, value ) => {
		const {
			post: { id },
		} = this.props;
		this.props.reloadFrame();
		this.props.updatePost( id, { [ name ]: value } );
	};

	renderInFrame = ( event, element ) => {
		const { post } = this.props;
		let val = '';

		if ( ! event.target ) {
			val = event;
		} else {
			val = event.target.value;
		}

		const update = ( { document: frame } ) => {
			if ( ! element.refreshWhen ) {
				this.props.reloadFrame();
				this.props.updatePost( post.id, { [ event.target.name ]: val } );
			}

			const refreshWhen = frame.querySelectorAll( element.refreshWhen );

			if ( refreshWhen.length >= 1 ) {
				Object.keys( element.update ).forEach( ( key ) => {
					element.update[ key ].forEach( ( { selector, html, type } ) => {
						const toUpdate = frame.querySelector( selector );
						// eslint-disable-next-line
						const newHtml = html.replace('${data}', val);

						if ( toUpdate && type !== 'updateText' ) {
							toUpdate.parentNode.removeChild( toUpdate );
						}

						const parent = frame.querySelector( key );

						switch ( type ) {
							case 'prepend': {
								const line = document.createElement( 'div' );
								line.innerHTML = newHtml;
								parent.insertBefore( line.firstChild, parent.firstChild );
								break;
							}
							case 'insertAfter':
								parent.insertAdjacentHTML( 'afterend', newHtml );
								break;
							case 'updateText':
								parent.innerHTML = val;
								break;
							default:
						}
					} );
				} );
			}
		};
		this.props.runOnFrame( update );
		this.props.updatePost( post.id, { [ event.target.name ]: val } );
	};

	render() {
		const {
			post: {
				name,
				type,
				downloadable,
				virtual,
				regular_price: regularPrice,
				download_expiry: downloadExpiry,
				download_limit: downloadLimit,
				sale_price: salePrice,
				description,
				short_description: shortDescription,
				categories: postCategories,
				tags: postTags,
				downloads
			},
			categories,
			tags,
			elements,
			loading,
		} = this.props;

		const { canCreateCategories, canCreateTags } = astoundifyWrp;

		return (
			<Tab title={ __( 'Details' )}>
				<Text
					id="name"
					label={ __( 'Product Name' ) }
					value={ name }
					onBlur={ this.handleSave }
					onChange={ ( event ) => this.updateFrameText( event, elements.title ) }
				/>

				<Select
					id="type"
					label={ __( 'Type' ) }
					options={ productType }
					value={ type }
					onChange={ this.saveAndReload }
				/>

				{ type === 'simple' && (
					<React.Fragment>
						<Checkbox
							id="virtual"
							label={ __( 'Virtual' ) }
							value={ !! virtual }
							onChange={ this.saveAndReload }
						/>
						<Text
							id="regular_price"
							label={ __( 'Regular Price' ) }
							value={ regularPrice }
							onChange={ this.updatePrice }
							onBlur={ this.handleSave }
						/>
						<Text
							id="sale_price"
							label={ __( 'Sale Price' ) }
							value={ salePrice }
							onChange={ this.updatePrice }
							onBlur={ this.handleSave }
						/>
					</React.Fragment>
				) }

				<TextArea
					id="description"
					label={ __( 'Description' ) }
					value={ description }
					onBlur={ this.saveAndReload }
					onChange={ () => null }
				/>

				<TextArea
					id="short_description"
					label={ __( 'Short Description') }
					value={ shortDescription }
					onBlur={ this.saveAndReload }
					onChange={ () => null }
				/>

				<MultiSelect
					id="categories"
					label={ __( 'Categories' ) }
					options={ categories }
					value={ postCategories.map( ( i ) => i.slug ) }
					onChange={ this.saveAndReload }
					valueKey="slug"
					labelKey="name"
					placeholder={ canCreateCategories ? __( 'Select or create a category...' ) : __( 'Select a category...' ) }
					onCreate={ canCreateCategories ? ( name ) => this.props.createCategory( name ) : null }
					loading={ loading.categories }
				/>

				<MultiSelect
					id="tags"
					label={ __( 'Tags' ) }
					options={ tags }
					value={ postTags.map( ( i ) => i.slug ) }
					onChange={ this.saveAndReload }
					valueKey="slug"
					labelKey="name"
					placeholder={ canCreateTags ? __( 'Select or create a tag...' ) : __( 'Select a tag...' ) }
					onCreate={ canCreateTags ? ( name ) => this.props.createTag( name ) : null }
					loading={ loading.tags }
				/>

				{ type === 'simple' && (
					<React.Fragment>
						<Checkbox
							id="downloadable"
							label="downloadable"
							value={ !! downloadable }
							onChange={ this.saveAndReload }
						/>
						{ !!downloadable && (
							<React.Fragment>

								<FileUpload
									onChange={ this.handleFileUploadSave }
									multiple={ true }
									downloads={downloads}
									id="downloads"
									label={ __( 'Downloads' ) }
								/>

								<Text
									id="download_limit"
									label={ __( 'Download limit' ) }
									value={ downloadLimit < 0 ? 0 : downloadLimit }
									onBlur={ this.saveAndReload }
									onChange={ () => null }
									tooltip={ __( 'Leave blank for unlimited re-downloads.' ) }
								/>

								<Text
									id="download_expiry"
									label={ __( 'Download Expiry' ) }
									value={ downloadExpiry < 0 ? 0 : downloadExpiry }
									onBlur={ this.saveAndReload }
									onChange={ () => null }
									tooltip={ __( 'Enter the number of days before a download link expires, or leave blank.' ) }
								/>

							</React.Fragment>
						) }
					</React.Fragment>
				) }
			</Tab>
		);
	}
}

const mapStateToProps = ( { post, categories, tags, loading } ) => ( {
	post,
	categories: categories.items,
	tags: tags.items,
	weightUnit: getWeightUnit(),
	dimensionsUnit: getDimensionsUnit(),
	elements: window.astoundifyWrp.elements,
	loading,
} );

export default connect( mapStateToProps, {
	updatePost,
	reloadFrame,
	runOnFrame,
	frameReady,
	createCategory,
	createTag,
} )( Details );
