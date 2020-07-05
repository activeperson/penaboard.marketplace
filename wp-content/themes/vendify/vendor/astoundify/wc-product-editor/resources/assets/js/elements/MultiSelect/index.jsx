import React from 'react';
import propTypes from 'prop-types';
import Downshift from 'downshift';
import LoadingOverlay from 'components/LoadingOverlay';

class MultiSelect extends React.Component {
  static propTypes = {
  	value: propTypes.arrayOf( propTypes.string ).isRequired,
  	id: propTypes.string.isRequired,
  	options: propTypes.arrayOf( propTypes.shape() ).isRequired,
  	onChange: propTypes.func.isRequired,
  	label: propTypes.string.isRequired,
  	placeholder: propTypes.string,
  	labelKey: propTypes.string,
  	valueKey: propTypes.string,
  	onCreate: propTypes.func,
  	loading: propTypes.bool,
  };

  static defaultProps = {
  	placeholder: '',
  	labelKey: 'label',
  	valueKey: 'value',
  	onCreate: null,
  	loading: false,
  };

  componentDidUpdate( prevProps ) {
  	const { onCreate, loading, id: name, options, valueKey } = this.props;
  	const { newItem, selectedItems } = this.state;

  	if ( ! onCreate ) {
  		return;
  	}

  	if (
  		prevProps.loading !== loading &&
			newItem !== '' &&
			prevProps.options.length !== options.length
  	) {
  		// eslint-disable-next-line
			this.setState({ newItem: '' });
  		this.selectItem( newItem );
  		const value = [ ...selectedItems, newItem ].map( ( item ) =>
  			options.find( ( option ) => option[ valueKey ] === item )
  		);
  		const event = {
  			target: {
  				name,
  				value,
  			},
  		};
  		this.props.onChange( event );
  	}
  }

  state = {
  	selectedItems: this.props.value,
  	newItem: '',
  };

  getOptions = ( options ) => options.map( ( option ) => option[ this.props.valueKey ] );

	handleChange = ( items ) => {
		const { id: name, options, valueKey, loading } = this.props;
		if ( loading ) {
			return;
		}
		const value = items.map( ( item ) =>
			options.find( ( option ) => option[ valueKey ] === item )
		);
		const event = {
			target: {
				name,
				value,
			},
		};
		this.props.onChange( event );
	};

  selectItem = ( item ) => {
  	if ( ! this.state.selectedItems.includes( item ) ) {
  		this.setState( { selectedItems: [ ...this.state.selectedItems, item ] } );
  		this.handleChange( [ ...this.state.selectedItems, item ] );
  	}
  };

	addItem = ( toCreate, clearSelection ) => {
		clearSelection();
		const { onCreate } = this.props;

		if ( '' == toCreate ) {
			return;
		}

		onCreate( toCreate );

		this.setState( { newItem: toCreate } );
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
		const { options, labelKey, valueKey } = this.props;
		if ( selectedItems.length === 0 ) {
			return null;
		}
		return (
			<div className="astoundify-wc-re-tags-list">
				{ selectedItems.map( ( value ) => {
					const item = options.find( ( option ) => option[ valueKey ] === value );
					if ( ! item ) {
						return null;
					}
					return (
						<div key={ value } className="btn btn-outline-neutral">
							{ item[ labelKey ].replace( /&amp;/g, '&' ) }
							<button
								className="close"
								onClick={ () => this.removeItem( value ) }
							/>
						</div>
					);
				} ) }
			</div>
		);
	};

	render() {
		const {
			id,
			label,
			options,
			placeholder,
			labelKey,
			valueKey,
			onCreate,
			loading,
		} = this.props;

		const items = this.getOptions( options );

		return (
			<LoadingOverlay loading={ loading }>
				<Downshift>
					{ ( { getInputProps, getItemProps, inputValue, isOpen, openMenu, closeMenu, clearSelection } ) => (
						<div className="form-group">
							<label className="form-label" htmlFor={ id }>
								{ label }
							</label>
							{ this.renderTags() }
							<input
								{ ...getInputProps( { id } ) }
								onFocus={ openMenu }
								onBlur={ closeMenu }
								className="form-control"
								placeholder={ placeholder }
							/>
							{ onCreate && inputValue && (
								<button
									className="form-control__add-tag"
									onClick={ () => this.addItem( inputValue, clearSelection ) }
								>
									+
								</button>
							) }
							{ isOpen ? (
								<div className="astoundify-wc-re-input-suggestions">
									{ items.length > 0 &&
											items
												.filter(
													( i ) => ! inputValue || i.includes( inputValue.toLowerCase() )
												)
												.map( ( item ) => (
													<button
														{ ...getItemProps( { item } ) }
														key={ item }
														onClick={ () => this.selectItem( item ) }
														className="astoundify-wc-re-input-suggestion"
													>
														{
															options.find( ( option ) => option[ valueKey ] === item )[ labelKey ].replace( /&amp;/g, '&' )
														}
													</button>
												) ) }
								</div>
							) : null }
						</div>
					) }
				</Downshift>
			</LoadingOverlay>
		);
	}
}

export default MultiSelect;
