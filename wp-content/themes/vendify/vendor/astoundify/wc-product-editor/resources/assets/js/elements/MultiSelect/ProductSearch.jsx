import React from 'react';
import propTypes from 'prop-types';
import Downshift from 'downshift';
import LoadingOverlay from 'components/LoadingOverlay/Element';

class ProductSearchMultiSelect extends React.Component {
  static propTypes = {
  	value: propTypes.arrayOf( propTypes.number ).isRequired,
  	id: propTypes.string.isRequired,
  	options: propTypes.arrayOf( propTypes.shape() ).isRequired,
  	onChange: propTypes.func.isRequired,
  	label: propTypes.string.isRequired,
  	placeholder: propTypes.string,
  	loading: propTypes.bool,
  };

  static defaultProps = {
  	placeholder: '',
  	loading: false,
  };

  state = {
  	selectedItems: this.props.value,
  };

  getLabel = ( value ) => {
  	const { options } = this.props;
  	return options.find( ( option ) => option.value === value ).label;
  };

  handleChange = ( items ) => {
  	const { id } = this.props;
  	const event = {
  		target: {
  			type: 'productSearch',
  			name: id,
  			value: items,
  		},
  	};
  	this.props.onChange( event );
  };

  selectItem = ( { value } ) => {
  	if ( ! this.state.selectedItems.includes( value ) ) {
  		this.setState( { selectedItems: [ ...this.state.selectedItems, value ] } );
  		this.handleChange( [ ...this.state.selectedItems, value ] );
  	}
  };

  removeItem = ( toRemove ) => {
  	this.setState( {
  		selectedItems: [
  			...this.state.selectedItems.filter( ( item ) => item !== toRemove ),
  		],
  	} );
  	this.handleChange( [
  		...this.state.selectedItems.filter( ( item ) => item !== toRemove ),
  	] );
  };

	renderTags = () => {
		const { selectedItems } = this.state;
		const { options } = this.props;

		if ( selectedItems.length === 0 || options.length === 0 ) {
			return null;
		}

		return (
			<div className="astoundify-wc-re-tags-list">
				{ selectedItems.map( ( value ) => (
					<div key={ value } className="btn btn-outline-neutral">
						{ this.getLabel( value ) }
						<button className="close" onClick={ () => this.removeItem( value ) } />
					</div>
				) ) }
			</div>
		);
	};

	render() {
		const { id, label, options, placeholder, loading } = this.props;
		const { selectedItems } = this.state;

		return (
			<div className="form-group">
				<label className="label" htmlFor={ id }>
					{ label }
				</label>

				<Downshift>
					{ ( {
						getInputProps,
						getItemProps,
						inputValue,
						isOpen,
						openMenu,
						closeMenu,
					} ) => (
						<div className="btn-group">
							<LoadingOverlay loading={ loading }>

								{ this.renderTags() }

								<input
									{ ...getInputProps( {
										id,
									} ) }
									onFocus={ openMenu }
									onBlur={ closeMenu }
									className="form-control"
									placeholder={ placeholder }
								/>

								{ isOpen ? (
									<div className="astoundify-wc-re-input-suggestions">
										{ options.length > 0 &&
												options
												.filter(
													( option ) =>
													! inputValue ||
													option.label
													.toLowerCase()
													.indexOf( inputValue.toLowerCase() ) !== -1
												)
												.filter(
													( option ) => selectedItems.indexOf( option.value ) === -1
												)
												.map( ( item ) => (
													<button
														{ ...getItemProps( { item: item.value } ) }
														key={ item.value }
														onClick={ () => this.selectItem( item ) }
														className="astoundify-wc-re-input-suggestion"
														value={ item.value }
													>
														{ item.label }
													</button>
												) ) }
											</div>
								) : null }
							</LoadingOverlay>
						</div>
					) }
				</Downshift>
			</div>
		);
	}
}

export default ProductSearchMultiSelect;
